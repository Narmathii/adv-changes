<?php

namespace App\Controllers;

require_once(APPPATH . "Libraries/razorpay/razorpay-php/Razorpay.php");
use Razorpay\Api\Api;

use App\Models\ProductTallyMappingModel;
use App\Models\PaymentRequestLog;
use App\Models\WebhookPaymentLog;



class WebhookController extends BaseController
{

	//public $data;
	public function __constructor()
	{
		//$this->data= [];
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

	public function paymentfail()
	{
		session()->set('payment_attempted', true);
		session()->set('payment_status', 'failed');
		session()->set('payment_redirect', 'payment-failed');

		return view('failure');
	}

	public function paymentcancel()
	{
		session()->set('payment_attempted', true);
		session()->set('payment_status', 'cancelled');
		session()->set('payment_redirect', 'cancel');

		$request = service('request');
		$data = $request->getGet();
		$db = \Config\Database::connect();

		$orderId = $request->getGet('order_id');
		$cancelReason = $request->getGet('reason') ?? 'User cancelled payment';
		$orderStatus = "Cancelled Transaction";
		$paymentStatus = 'CANCELLED';

		$deliveryStatus = 'Cancelled';
		$deliveryConfig = new \Config\DeliveryMessages();
		$deliveryMsg = $deliveryConfig->messages[$deliveryStatus] ?? 'No message available';

		$updateOrderQry = "
        UPDATE `tbl_orders` 
        SET `payment_status` = ?, 
            `cancel_reason` = ?,
             `delivery_message` = ?,
             `delivery_status` = ?, 
            `updated_at` = NOW(),
            `order_status` = ?
        WHERE `order_id` = ?
    ";
		$updateOrder = $db->query($updateOrderQry, [$paymentStatus, $cancelReason, $deliveryMsg, $deliveryStatus, $orderStatus, $orderId]);

		$affectedRows = $db->affectedRows();

		if ($affectedRows) {
			return view('cancelled', ['cancelled_reason' => $cancelReason]);
		} else {
			return view('cancelled', ['cancel_reason' => 'Could not update cancellation status.']);
		}
	}

	public function paymentstatus()
	{

		$tallyModal = new ProductTallyMappingModel();
		$webhookLog = new WebhookPaymentLog();

		$this->session = \Config\Services::session();
		$db = \Config\Database::connect();

		$payload = file_get_contents("php://input");

		$signature = $_SERVER['HTTP_X_RAZORPAY_SIGNATURE'] ?? '';
		$webhookSecret = getenv('RAZORPAY_WEBHOOK_SECRET_TEST');

		// Verify signature
		// $expectedSignature = hash_hmac('sha256', $payload, $webhookSecret);
		// if (!hash_equals($expectedSignature, $signature)) {
		// 	return $this->response->setStatusCode(403)->setJSON(['message' => 'Invalid signature']);
		// }

		$data = json_decode($payload, true);

		$event = $data['event'];


		$payment = $data['payload']['payment']['entity'];

		// For Failure
		$reason = $payment['error_reason'] ?? '';
		$code = $payment['error_code'] ?? '';
		$description = $payment['error_description'] ?? '';

		$razorpay_payment_id = $payment['id'];
		$razorpay_order_id = $payment['order_id'];
		$payment_status = $payment['status'];

		$orderid = $payment['notes']['order_id'] ?? $payment['order_id'] ?? null;
		$notes = $payment['notes'];


		$db->table('webhook_event')->insert([
			'event' => $event,
			'orderid' => $orderid
		]);

		if ($event === 'payment.captured') {
			// webhook-log
			$createdAt = time();
			$dateTime = (new \DateTime("@$createdAt"))
				->setTimezone(new \DateTimeZone('Asia/Kolkata'))
				->format('Y-m-d H:i:s');

			$webhook_log_data = [
				'order_id' => $notes['order_id'],
				'user_id' => $notes['user_id'],
				'username' => $notes['username'],
				'razorpay_payment_id' => $razorpay_payment_id,
				'razorpay_order_id' => $razorpay_order_id,
				'razorpay_signature' => $signature,
				'date_time' => $dateTime,
				'payment_method' => $payment['method'],
				'total_amount' => $payment['amount'],
				'payment_status' => $payment['status']
			];
			$webhookLog->insert($webhook_log_data);

		} else if ($event === 'order.paid') {
			$payment_method = $payment['method'];

			$userID = $notes['user_id'];
			$orderID = $orderid;
			$username = $notes['username'];


			// Updating Order Status
			$deliveryStatus = 'New';
			$deliveryConfig = new \Config\DeliveryMessages();
			$deliveryMsg = $deliveryConfig->messages[$deliveryStatus] ?? 'No message available';


			$payment_status = 'COMPLETED';
			$orderstatus = "success";


			$orderQry = "UPDATE tbl_orders SET razerpay_payment_id = ?,razerpay_order_id = ?,razerpay_signature = ?,order_status = ? ,delivery_message = ?,delivery_status = ?,payment_status = ?,payment_method = ? WHERE order_id = ?";
			$updateData = $db->query($orderQry, [$razorpay_payment_id, $razorpay_order_id, $signature, $orderstatus, $deliveryMsg, $deliveryStatus, $payment_status, $payment_method, $orderID]);
			$affectedRows = $db->affectedRows();

			if ($affectedRows > 0) {
				$sess = [
					'user_id' => $userID,
					'username' => $username,
					'loginStatus' => "YES",
					'otp_verify' => "YES"
				];
				$this->session->set($sess);



				// Delete Products from cart 
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
					$updateQry = "UPDATE  `$tblName` SET quantity = ? WHERE prod_id = ?";
					$updateRes = $db->query($updateQry, [$updatedQty, $prodID]);


					$payment_status = 'COMPLETED';

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

								$updateConfigRes = $db->query($updateConfigQry, [null, $updatedSizeData, $updatedStockData, $prodID, $tblName]);
							}
						}
					}

				}
				$result = [
					'code' => 200,
					'status' => 'success',
					'message' => "Orders updated successfully"
				];
			}
			echo json_encode($result);

		} elseif ($event === 'payment.failed') {
			$orderID = $orderid;
			$payment_status = 'FAILED';
			$order_status = "Failure";

			$deliveryStatus = 'Cancelled';
			$deliveryConfig = new \Config\DeliveryMessages();
			$deliveryMsg = $deliveryConfig->messages[$deliveryStatus] ?? 'No message available';


			$updateOrderQry = "UPDATE `tbl_orders` SET  razerpay_payment_id = ? , razerpay_order_id =? , razerpay_signature = ? ,delivery_message = ?,delivery_status = ? ,`payment_status` = ? , `cancel_reason` =? ,`order_status` = ? WHERE order_id = ?";
			$updateData = $db->query($updateOrderQry, [$razorpay_payment_id, $razorpay_order_id, $signature, $deliveryMsg, $deliveryStatus, $payment_status, $reason, $order_status, $orderid]);
			return $this->response->setStatusCode(200)->setJSON(['message' => "Payment failed data updated successfully"]);

		} elseif ($event === 'payment.authorized') {

			$Orderstatus = 'Pending';

			$deliveryStatus = 'Order pending';
			$deliveryConfig = new \Config\DeliveryMessages();
			$deliveryMsg = $deliveryConfig->messages[$deliveryStatus] ?? 'No message available';

			$payment_status = 'PENDING';
			$orderQry = "UPDATE tbl_orders SET razerpay_payment_id = ?,razerpay_order_id = ?,razerpay_signature = ?,order_status = ? ,
						 delivery_message = ?,delivery_status = ?,payment_status = ? WHERE order_id = ?";
			$updateData = $db->query($orderQry, [$razorpay_payment_id, $razorpay_order_id, $signature, $Orderstatus, $deliveryMsg, $deliveryStatus, $payment_status, $orderid]);
			return $this->response->setStatusCode(200)->setJSON(['message' => "Payment pending data updated successfully"]);

		}
	}

public function webhookPaymentLog()
	{
		$webhookLog = new WebhookPaymentLog();
		$payload = file_get_contents("php://input");

		$webhookSecret = getenv('RAZORPAY_WEBHOOK_SECRET');
		$signature = $_SERVER['HTTP_X_RAZORPAY_SIGNATURE'] ?? '';

		// Verify signature
		$expectedSignature = hash_hmac('sha256', $payload, $webhookSecret);
		if (!hash_equals($expectedSignature, $signature)) {

			return $this->response
				->setStatusCode(200)
				->setJSON(['message' => 'Signature invalid, but acknowledged']);
		}

		$data = json_decode($payload, true);

		$eventLog = json_encode($data);
		$payment = $data['payload']['payment']['entity'];

		// Error details (for failed payments)
		$reason = $payment['error_reason'] ?? '';
		$code = $payment['error_code'] ?? '';
		$description = $payment['error_description'] ?? '';

		$razorpay_payment_id = $payment['id'] ?? null;
		$razorpay_order_id = $payment['order_id'] ?? null;
		$payment_status = $payment['status'] ?? null;
		$notes = $payment['notes'] ?? [];

		$order_id = $notes['order_id'] ?? $razorpay_order_id;
		$user_id = $notes['user_id'] ?? null;
		$username = $notes['username'] ?? null;

		$createdAt = time();
		$dateTime = (new \DateTime("@$createdAt"))
			->setTimezone(new \DateTimeZone('Asia/Kolkata'))
			->format('Y-m-d H:i:s');


		$webhook_log_data = [
			'order_id' => $order_id,
			'user_id' => $user_id,
			'username' => $username,
			'razorpay_payment_id' => $razorpay_payment_id,
			'razorpay_order_id' => $razorpay_order_id,
			'date_time' => $dateTime,
			'payment_method' => $payment['method'] ?? null,
			'total_amount' => $payment['amount'] ?? 0,
			'payment_status' => $payment_status,
			'event_log' => $eventLog,
		];

		$webhookLog->insert($webhook_log_data);

		return $this->response
			->setStatusCode(200)
			->setJSON(['message' => "Webhook event saved successfully!"]);
	}
    
}


