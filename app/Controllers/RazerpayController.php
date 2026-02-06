<?php

namespace App\Controllers;

require_once(APPPATH . "Libraries/razorpay/razorpay-php/Razorpay.php");
use Razorpay\Api\Api;

use App\Models\ProductTallyMappingModel;
use App\Models\PaymentRequestLog;
use App\Models\OrderPendingModel;


class RazerpayController extends BaseController
{

	//public $data;
	public function __constructor()
	{
		//$this->data= [];
	}
	public function payment()
	{
		$db = \Config\Database::connect();
		$paymentRequestLogModel = new PaymentRequestLog;
		//$this->data['db'] = $db;
		$orderID = session()->get('order_id');

		$data = $this->request->getPost();

		$previousURL = previous_url();

		// Check the orderID is already has rzporderID
		$orderQuery = "SELECT `order_id` 
                        FROM `tbl_orders` 
                        WHERE `order_id` = ?
                        AND (
                            (`razerpay_payment_id` IS NOT NULL AND `razerpay_payment_id` != '')
                            AND
                            (`razerpay_order_id` IS NOT NULL AND `razerpay_order_id` != '')
                            AND
                            (`razerpay_signature` IS NOT NULL AND `razerpay_signature` != '')
                        )";
		$checkOrder = $db->query($orderQuery, [$orderID])->getRow();
		$oldOrder = $checkOrder->order_id;

		if ($oldOrder != '') {
			return redirect()->to('myorders');
		}
		// Check the orderID is already has rzp orderID



		$userID = session()->get('user_id');
		$query = "SELECT a.`username`,a.`number` ,a.`email` ,b.`sub_total`
        FROM `tbl_users` AS a INNER JOIN tbl_orders AS b ON a.`user_id` = b.user_id
        WHERE a.`user_id` = $userID AND  a.`flag` = 1  AND  b.`flag` = 1  AND b.order_id = $orderID";

		$userData = $db->query($query)->getRow();


		$key_id = $_ENV['RAZORPAY_KEY_ID'];
		$secret = $_ENV['RAZORPAY_KEY_SECRET'];

		$api = new Api($key_id, $secret);

		$amount = $userData->sub_total;

		$totalAmt = $amount * 100;

		$order = $api->order->create([
			'receipt' => 'ORD_' . $orderID . '_' . time(),
			'amount' => $totalAmt,
			'currency' => 'INR',
			'notes' => [
				'user_id' => $userID,
				'order_id' => $orderID,
				'username' => $userData->username,

			]
		]);

		$customerData = [
			'name' => $userData->username,
			'email' => $userData->email,
			'number' => $userData->number,
			'user_id' => $userID,
			'order_id' => $orderID,

		];


		// Payment request Log
		$createdAt = time();
		$dateTime = (new \DateTime("@$createdAt"))
			->setTimezone(new \DateTimeZone('Asia/Kolkata'))
			->format('Y-m-d H:i:s');

		$getOrderItem = $db->query("SELECT * FROM `tbl_order_item` WHERE `order_id` = ? AND `flag` = 1", [$orderID])->getResultArray();



		for ($i = 0; $i <= count($getOrderItem); $i++) {
			$prodID = $getOrderItem[$i]['prod_id'];
			$table_name = $getOrderItem[$i]['table_name'];
			$quantity = $getOrderItem[$i]['quantity'];
			$prod_price = $getOrderItem[$i]['prod_price'];
			$sub_total = $getOrderItem[$i]['sub_total'];
			$size = $getOrderItem[$i]['size'];
			$mrp = $getOrderItem[$i]['mrp'];
			$offer_type = $getOrderItem[$i]['offer_type'];
			$offer_details = $getOrderItem[$i]['offer_details'];
			$offer_price = $getOrderItem[$i]['offer_price'];

			if (empty($prodID)) {
				continue;
			}

			$logData = [
				'order_id' => $orderID,
				'user_id' => $userID,
				'username' => $userData->username,
				'date_time' => $dateTime,
				'total_amount' => $totalAmt,
				'prod_id' => (int) $prodID,
				'table_name' => $table_name,
				'quantity' => (int) ($quantity ?? 0),
				'prod_price' => $prod_price ?? null,
				'sub_total' => $sub_total ?? null,
				'size' => $size ?? null,
				'mrp' => $mrp ?? null,
				'offer_type' => $offer_type ?? null,
				'offer_details' => $offer_details ?? null,
				'offer_price' => $offer_price ?? null,
			];

			$paymentRequestLogModel->insert($logData);
		}

		return view("payment", ['customerdata' => $customerData, 'order' => $order, 'key_id' => $key_id, 'secret' => $secret, 'previous_url' => $previousURL]);
	}


	public function paymentcancel($segment)
	{

		$userID = session()->get('user_id');
		$data = $this->request->getPost();


		$db = \Config\Database::connect();
		$response_data = $segment;

		parse_str($response_data, $response_params);
		$reason = isset($response_params['reason']) ? $response_params['reason'] : null;
		$razerpayOrderID = isset($response_params['order_id']) ? $response_params['order_id'] : null;


		// Updating razerpay order id ,payment id ,paymentstatus 
		$orderID = session()->get('order_id');
		$deliveryMsg = 6;
		$payment_id = "NULL";
		$razorpay_signature = "NULL";
		$Orderstatus = "Cancelled Transaction";
		$deliveryStatus = 6;
		$payment_status = 4;
		$cancelReason = "Payment was Cancelled by customer";
		$orderQry = "UPDATE tbl_orders SET razerpay_payment_id = ?,razerpay_order_id = ?,razerpay_signature = ?,order_status = ? ,delivery_message = ? ,delivery_status = ?,payment_status = ?,cancel_reason= ? WHERE order_id = ?";
		$updateData = $db->query($orderQry, [$payment_id, $razerpayOrderID, $razorpay_signature, $Orderstatus, $deliveryMsg, $deliveryStatus, $payment_status, $cancelReason, $orderID]);

		if ($updateData) {
			$data = [
				'reason' => $reason,
				'order_id' => $razerpayOrderID,
				'status' => 'cancelled'
			];
			return view("cancelled", $data);
		}

	}

	public function paymentfail($segment)
	{
		$orderID = session()->get('user_id');

		$db = \Config\Database::connect();
		$response_data = $segment;


		parse_str($response_data, $response_params);

		// Extract individual parameters
		$order_id = isset($response_params['order_id']) ? $response_params['order_id'] : null;
		$payment_id = isset($response_params['payment_id']) ? $response_params['payment_id'] : null;
		$Orderstatus = 'Failure';
		$razorpay_signature = "NULL";
		$cancelReason = "Payment was unsuccessful as it was cancelled by the customer.";


		// Updating razerpay order id ,payment id ,paymentstatus 
		$orderID = session()->get('order_id');
		$deliveryMsg = 6;
		$deliveryStatus = 6;
		$payment_status = 3;
		$orderQry = "UPDATE tbl_orders SET razerpay_payment_id = ?,razerpay_order_id = ?,razerpay_signature = ?,order_status = ? ,
		             delivery_message = ?,delivery_status = ?,payment_status = ? ,cancel_reason = ? WHERE order_id = ?";
		$updateData = $db->query($orderQry, [$payment_id, $order_id, $razorpay_signature, $Orderstatus, $deliveryMsg, $deliveryStatus, $payment_status, $cancelReason, $orderID]);

		$data = [
			'orderid' => $order_id,
			'paymentid' => $payment_id,
			'status' => $Orderstatus,
		];

		if ($updateData) {
			return view("failure", $data);
		}
	}

	public function paymentstatus()
	{
		// Load the model
		$tallyModal = new ProductTallyMappingModel();

		$this->session = \Config\Services::session();
		$db = \Config\Database::connect();
		$data = $this->request->getPost();


		$razorpay_payment_id = $this->request->getPost('razorpay_payment_id');
		$razorpay_order_id = $this->request->getPost('razorpay_order_id');
		$razorpay_signature = $this->request->getPost('razorpay_signature');
		$orderstatus = "success";

		$secret = $_ENV['RAZORPAY_KEY_SECRET'];
		$api = new Api($_ENV['RAZORPAY_KEY_ID'], $secret);

		$data = $razorpay_order_id . "|" . $razorpay_payment_id;


		$generated_signature = hash_hmac("sha256", $data, $secret);
		// to get payment method
		$payment = $api->payment->fetch($razorpay_payment_id);

		$razerpay_paystatus = $payment->status;


		if ($razerpay_paystatus == "captured") {
			if ($generated_signature == $razorpay_signature) {
				$payment_method = $payment->method;

				// to get orderID,Userid 
				$orderDetails = $this->fetchOrderDetails($razorpay_order_id, $secret);

				$userID = $orderDetails['notes']['user_id'];
				$orderID = $orderDetails['notes']['order_id'];
				$username = $orderDetails['notes']['username'];

				$sess = [
					'user_id' => $userID,
					'username' => $username,
					'loginStatus' => "YES",
					'otp_verify' => "YES"
				];
				$this->session->set($sess);

				// After successful payment delete the products from cart
				$query = "SELECT a.cart_id, a.`table_name`, a.`prod_id`, a.`quantity`, a.`prod_price`, a.`sub_total`, b.add_id 
				FROM `tbl_user_cart` AS a 
				INNER JOIN tbl_user_address AS b ON a.`user_id` = b.user_id 
				WHERE a.flag = 1 AND b.flag = 1 AND a.user_id = $userID  AND b.default_addr = 1";

				$cartData = $db->query($query)->getResultArray();


				foreach ($cartData as $cartItem) {
					$prodID = $cartItem['prod_id'];
					$tblName = $cartItem['table_name'];
					$cartID = $cartItem['cart_id'];
					$dltcart = "DELETE FROM tbl_user_cart WHERE cart_id = $cartID AND prod_id = $prodID";
					$dltRes = $db->query($dltcart);
				}


				// Updating quatity to products tbl based on checkout products 
				$itemList = $db->query("SELECT * FROM `tbl_order_item` WHERE `order_id` =  $orderID  AND `flag` = 1")->getResultArray();


				foreach ($itemList as $items) {
					$prodID = $items['prod_id'];
					$tblName = $items['table_name'];
					$checkoutQty = $items['quantity'];
					$size = $items['size'];
					$color = $items['color'];



					// get product qty from product table
					$getqty = "SELECT `quantity` FROM `$tblName` WHERE `prod_id` = ? AND flag = 1";
					$oldQty = $db->query($getqty, [$prodID])->getRow();

					$oldQtyValue = $oldQty->quantity;

					$updatedQty = $oldQtyValue - $checkoutQty;

					// update new qty to product table
					$db->query("SET @source = 'appteq'");
					$updateQry = "UPDATE  `$tblName` SET quantity = ? WHERE prod_id = ? AND tbl_name = ?";
					$updateRes = $db->query($updateQry, [$updatedQty, $prodID, $tblName]);


					$payment_status = 2;

					$menuMappings = [
						'tbl_accessories_list' => [
							'menuid' => 'access_id',
							'submenuid' => 'sub_access_id',
							'tbl_menu' => 'tbl_access_master',
							'tbl_submenu' => 'tbl_subaccess_master',
							'accessid' => 'access_id',
							'mname' => 'access_title',
							'subname' => 'sub_access_name'
						],
						'tbl_rproduct_list' => [
							'menuid' => 'r_menu_id',
							'submenuid' => 'r_sub_id',
							'tbl_menu' => 'tbl_riding_menu',
							'tbl_submenu' => 'tbl_riding_submenu',
							'accessid' => 'r_menu_id',
							'mname' => 'r_menu',
							'subname' => 'r_sub_menu'
						],
						'tbl_helmet_products' => [
							'menuid' => 'h_menu_id',
							'submenuid' => 'h_submenu_id',
							'tbl_menu' => 'tbl_helmet_menu',
							'tbl_submenu' => 'tbl_helmet_submenu',
							'accessid' => 'h_menu_id',
							'mname' => 'h_menu',
							'subname' => 'h_submenu'
						],
						'tbl_luggagee_products' => [
							'menuid' => 'lug_menu_id',
							'submenuid' => 'lug_submenu_id',
							'tbl_menu' => 'tbl_luggage_menu',
							'tbl_submenu' => 'tbl_luggage_submenu',
							'accessid' => 'lug_menu_id',
							'mname' => 'lug_menu',
							'subname' => 'lug_submenu'
						],
						'tbl_camping_products' => [
							'menuid' => 'camp_menu_id',
							'submenuid' => 'c_submenu_id'

						]
					];

					// Get menu and submenu from mappings
					if (isset($menuMappings[$tblName])) {
						$MenuID = $menuMappings[$tblName]['menuid'];
						$subMenuID = $menuMappings[$tblName]['submenuid'];

						$tblMenu = $menuMappings[$tblName]['tbl_menu'] ?? null;
						$tblSubmenu = $menuMappings[$tblName]['tbl_submenu'] ?? null;

						$menuName = $menuMappings[$tblName]['mname'] ?? null;
						$SubmenuName = $menuMappings[$tblName]['subname'] ?? null;

						$accessID = $menuMappings[$tblName]['accessid'];

						// Construct the query based on table  [Beacause Camping products dont have submenus]
						if ($tblName == 'tbl_camping_products') {
							$query = "SELECT a.`$MenuID`, a.`$subMenuID`, b.camp_menu AS menu, c.c_submenu  AS submenu
						FROM `$tblName` AS a
						INNER JOIN tbl_camping_menu AS b ON a.`camp_menu_id` = b.camp_menu_id
						INNER JOIN tbl_camping_submenu AS c ON c.c_submenu_id = a.c_submenu_id
						WHERE a.prod_id = ?";
						} else {
							$query = "SELECT a.`$MenuID`,a.`$subMenuID` , b.`$menuName` AS menu, c.`$SubmenuName` AS submenu
						FROM `$tblName` AS a
						INNER JOIN `$tblMenu` AS b ON a.`$accessID` = b.`$accessID`
						INNER JOIN `$tblSubmenu` AS c ON c.`$subMenuID` = a.`$subMenuID`
						WHERE a.prod_id = ?";
						}

						$getMenuData = $db->query($query, [$prodID])->getResultArray();
					}

					// Tally Datas --------------------------------------------------
					$query = "SELECT c.product_name ,c.product_price AS actual_price,c.offer_price,c.offer_type,c.offer_details, b.sub_total  , a.courier_charge , a.sub_total AS total  , 
					a.order_id ,a.order_no,b.quantity,
					a.`payment_status`
					FROM tbl_orders AS a INNER JOIN tbl_order_item AS b 
					ON a.order_id = b.order_id INNER JOIN  $tblName AS c 
					ON b.prod_id = c.prod_id                                                                                                                                                                        
					WHERE  a.order_id = ?   AND c.prod_id = ?";

					$getResult = $db->query($query, [$orderID, $prodID])->getResultArray();

					$getUser = $db->query("SELECT `username`  FROM `tbl_users` WHERE `user_id` = $userID AND `flag` = 1")->getRow();
					$userName = $getUser->username;


					if ($size != '0') {
						$tallySize = $size;
					} else {
						$tallyColor = "null";
						$tallySize = "null";
					}

					// update Tally datas
					$tallyData = [
						'order_id' => $orderID,
						'order_no' => $getResult[0]['order_no'],
						'prod_id' => $prodID,
						'product_name' => $getResult[0]['product_name'],
						'customer_name' => $userName,
						'tbl_name' => $tblName,
						'old_quantity' => $oldQtyValue,
						'new_quantity' => $updatedQty,
						'shipping_qty' => $checkoutQty,
						'courier_charge' => $getResult[0]['courier_charge'],
						'total_amount' => $getResult[0]['total'],
						'payment_status' => $payment_status,
						'product_price' => $getResult[0]['sub_total'],
						'actual_price' => $getResult[0]['actual_price'],
						'offer_price' => $getResult[0]['offer_price'],
						'offer_type' => $getResult[0]['offer_type'],
						'offer_details' => $getResult[0]['offer_details'],
						'color' => 0,
						'size' => $tallySize,
						'menu' => $getMenuData[0]['menu'],
						'submenu' => $getMenuData[0]['submenu'],
						'tally_sync_status' => 'pending'
					];



					$order_number = $getResult[0]['order_no'];
					$check_old = "SELECT * FROM `tally_details` WHERE 1 AND `order_no` = ?;";
					$getOldData = $db->query($check_old, [$order_number])->getResultArray();

					if (count($getOldData) <= 0) {
						$insertData = $tallyModal->insert($tallyData);
					}

					if ($size != '0') {
						if ($updateRes) {
							$configQry = "SELECT `config_id`,`prod_id`,`tbl_name`,`size`,`soldout_status` FROM `tbl_configuration`
						WHERE `flag` = 1 AND prod_id = ? AND tbl_name = ?";
							$res = $db->query($configQry, [$prodID, $tblName])->getResultArray();


							if (!empty($res)) {
								$SizeData = json_decode($res[0]['size']);
								$stockData = json_decode($res[0]['soldout_status']);

								// Update stock based on size and color
								for ($i = 0; $i < count($SizeData); $i++) {
									if ($SizeData[$i] == $size) {
										$oldStock = $stockData[$i];
										$newStock = $oldStock - $checkoutQty;
										$stockData[$i] = $newStock;
									}
								}

								// Encode the updated data back to JSON

								$updatedSizeData = json_encode($SizeData);
								$updatedStockData = json_encode($stockData);


								$updateConfigQry = "UPDATE tbl_configuration 
                            SET colour = ?, size = ?, soldout_status = ?
                            WHERE prod_id = ? AND tbl_name = ? AND flag = 1";

								$updateConfigRes = $db->query($updateConfigQry, [$updatedColorData, $updatedSizeData, $updatedStockData, $prodID, $tblName]);
							}
						}
					}

				}

				// Updating razerpay order id ,payment id ,paymentstatus to order tbl
				$deliveryMsg = 2;
				$deliveryStatus = 2;

				// Payment request Log
				$createdAt = time();
				$dateTime = (new \DateTime("@$createdAt"))
					->setTimezone(new \DateTimeZone('Asia/Kolkata'))
					->format('Y-m-d H:i:s');

				$orderQry = "UPDATE tbl_orders SET razerpay_payment_id = ?,razerpay_order_id = ?,razerpay_signature = ?,order_status = ? ,delivery_message = ?,delivery_status = ?,payment_status = ?,payment_method = ? ,order_time = ?  WHERE order_id = ?";
				$updateData = $db->query($orderQry, [$razorpay_payment_id, $razorpay_order_id, $razorpay_signature, $orderstatus, $deliveryMsg, $deliveryStatus, $payment_status, $payment_method, $dateTime, $orderID]);

				$affectedRows = $db->affectedRows();

				if ($affectedRows == 1) {
					$successData = [
						'orderid' => $razorpay_order_id,
						'paymentid' => $razorpay_payment_id,
						'status' => $orderstatus,
					];


					session()->set($successData);

					$result['code'] = 200;
					$result['status'] = 'success';
					$result['message'] = "Stock updated successfully";
					return $this->response->setJSON($result);
				} else {
					echo "error";
				}
			}

		} else if ($razerpay_paystatus == "pending") {

			$Orderstatus = 'Pending';
			$razorpay_signature = "NULL";

			// Updating razerpay order id ,payment id ,paymentstatus 
			$orderID = session()->get('order_id');
			$deliveryMsg = "Your order is pending.";
			$deliveryStatus = 1;
			$payment_status = 1;
			$orderQry = "UPDATE tbl_orders SET razerpay_payment_id = ?,razerpay_order_id = ?,razerpay_signature = ?,order_status = ? ,
						 delivery_message = ?,delivery_status = ?,payment_status = ? WHERE order_id = ?";
			$updateData = $db->query($orderQry, [$razorpay_payment_id, $razorpay_order_id, $razorpay_signature, $Orderstatus, $deliveryMsg, $deliveryStatus, $payment_status, $orderID]);
		}


	}

	public function fetchOrderDetails($razorpay_order_id, $secret)
	{
		$key_id = $_ENV['RAZORPAY_KEY_ID'];

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://api.razorpay.com/v1/orders/' . $razorpay_order_id);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($ch, CURLOPT_USERPWD, $key_id . ':' . $secret);

		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		}
		curl_close($ch);

		return json_decode($result, true);
	}

	public function Success()
	{
		$successData = [
			'orderid' => session()->get('orderid'),
			'paymentid' => session()->get('paymentid'),
			'status' => session()->get('status'),
		];

		return view('success', $successData);

	}

	public function paymentPending()
	{
		$db = \Config\Database::connect();

		$ordersPendingModel = new OrderPendingModel();


		$order_id = $this->request->getPost('order_id');
		$user_id = $this->request->getPost('user_id');
		$rzp_orderid = $this->request->getPost('rzporder_id');
		$order_pending_log = json_encode($this->request->getPost());


		if (!$order_id || !$user_id) {
			return $this->response->setJSON([
				'status' => 'error',
				'message' => 'Missing required fields'
			]);
		}

		$finalData = [
			'order_id' => $order_id,
			'user_id' => $user_id,
			'rzporder_id' => $rzp_orderid,
			'order_pending_log' => $order_pending_log,
		];



		$ordersPendingModel->insert($finalData);

		if ($db->affectedRows() > 0) {
			return $this->response->setJSON([
				'status' => 'success',
				'message' => 'Pending order stored successfully'
			]);
		} else {
			return $this->response->setJSON([
				'status' => 'error',
				'message' => 'No record updated (check order_id, user_id, or flag)'
			]);
		}
	}
}