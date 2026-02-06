<?php
namespace App\Controllers\admin;
use Razorpay\Api\Api;
use Dompdf\Dompdf;
use App\Models\ProductTallyMappingModel;

class OrderListController extends BaseController
{
    private $apiKey;
    private $apiSecret;
    private $api;

    public function __construct()
    {
        $this->apiKey = $_ENV['RAZORPAY_KEY_ID'];
        $this->apiSecret = $_ENV['RAZORPAY_KEY_SECRET'];

        $this->api = new Api($this->apiKey, $this->apiSecret);
    }

    public function orderList()
    {

        $session = \Config\Services::session();

        if ($session->get('login_sts') == "") {
            return redirect()->to('admin');
        } else {
            return view("admin/orderList");
        }
    }

    public function getOrderList()
    {
        $db = \Config\Database::connect();
        $query =
            "SELECT a.*, b.*, DATE_FORMAT(a.order_date, '%d-%m-%Y') AS date ,
             CASE
                WHEN a.order_time IS NULL OR a.order_time = '0000-00-00 00:00:00' THEN '00:00:00'
                ELSE DATE_FORMAT(a.order_time, '%h:%i %p')
            END AS order_time,   
            
            DATE_FORMAT(a.delivery_date, '%d-%m-%Y')  AS deliverydate
            FROM tbl_orders AS a INNER JOIN 
            tbl_users AS b ON a.`user_id` = b.user_id
            WHERE a.flag = 1 AND b.flag = 1 AND a.order_status <> 'initiated' AND  a.payment_status <> 'PENDING'";
        $orderDetail = $db->query($query)->getResultArray();

        echo json_encode($orderDetail);
    }

    public function getOrderDetails()
    {
        $db = \Config\Database::connect();
        $orderID = $this->request->getPost('order_id');

       
        $query = "SELECT * FROM `tbl_order_item` WHERE `flag` = 1 AND `order_id` = ?";
        $itemDetails = $db->query($query, [$orderID])->getResultArray();




        $data = [];

        for ($i = 0; $i < count($itemDetails); $i++) {

            $prodID = $itemDetails[$i]['prod_id'];
            $tableName = $itemDetails[$i]['table_name'];
            $color = $itemDetails[$i]['color'];
            $hexCode = $itemDetails[$i]['hex_code'];
            $size = $itemDetails[$i]['size'];
            $mrp = $itemDetails[$i]['mrp'];
            $offerPrice = $itemDetails[$i]['offer_price'];
            $offerType = $itemDetails[$i]['offer_type'];
            $offerDetails = $itemDetails[$i]['offer_details'];


            $itemQuery = "SELECT 
                a.order_id, a.order_no, a.sub_total, a.courier_charge, a.order_status, 
                a.log AS order_time, a.order_date, a.razerpay_payment_id, a.payment_status, 
                a.delivery_status, a.cancel_reason, a.courier_type,
                b.quantity, b.prod_price, b.sub_total AS product_price, 
                b.color, b.hex_code, b.size, b.config_image1, b.color_name, 
                c.product_name, c.product_img, c.stock_status,c.drop_shipping,
                d.*, e.state_title, f.dist_name, 
                g.number, g.username, g.email
            FROM 
                tbl_orders AS a 
            LEFT JOIN 
                tbl_order_item AS b ON a.order_id = b.order_id 
            LEFT JOIN 
                $tableName AS c ON b.prod_id = c.prod_id
            INNER JOIN 
                tbl_user_address AS d ON a.add_id = d.add_id
            INNER JOIN 
                tbl_state AS e ON e.state_id = d.state_id
            INNER JOIN 
                tbl_district AS f ON f.dist_id = d.dist_id
            INNER JOIN 
                tbl_users AS g ON g.user_id = d.user_id
            WHERE 
                d.default_addr = 1 
                AND d.flag = 1 
                AND b.order_id = ? 
                AND c.prod_id = ? 
               
                AND a.flag = 1 
                AND b.size = ?";

            $itemRes = $db->query($itemQuery, [$orderID, $prodID, $size])->getRowArray();


            if ($itemRes) {
                $itemRes['actual_price'] = $mrp;
                $itemRes['offer_price'] = $offerPrice;
                $itemRes['offer_type'] = $offerType;
                $itemRes['offer_details'] = $offerDetails;
                $data[] = $itemRes;
            }

        }




        $orderSummaries[$orderID] = $data;




        $res = $orderSummaries[$orderID];


        echo json_encode($res);

    }

    public function getCancelOrderDetails()
    {
        $db = \Config\Database::connect();
        $orderID = $this->request->getPost('order_id');



        $query = "SELECT * FROM `tbl_order_item` WHERE `flag` = 1 AND `order_id` = ?";
        $itemDetails = $db->query($query, [$orderID])->getResultArray();


        $data = [];

        for ($i = 0; $i < count($itemDetails); $i++) {

            $prodID = $itemDetails[$i]['prod_id'];
            $tableName = $itemDetails[$i]['table_name'];
            $color = $itemDetails[$i]['color'];
            $hexCode = $itemDetails[$i]['hex_code'];
            $size = $itemDetails[$i]['size'];
            $mrp = $itemDetails[$i]['mrp'];
            $offerPrice = $itemDetails[$i]['offer_price'];
            $offerType = $itemDetails[$i]['offer_type'];
            $offerDetails = $itemDetails[$i]['offer_details'];


            $itemQuery = "SELECT
                            a.order_id,
                            a.order_no,
                            a.sub_total,
                            a.courier_charge,
                            a.order_status,
                            a.log AS order_time,
                            a.order_date,
                            a.razerpay_payment_id,
                            a.payment_status,
                            a.delivery_status,
                            a.cancel_reason,
                            a.courier_type,
                            b.quantity,
                            b.prod_price,
                            b.sub_total AS product_price,
                            b.color,
                            b.hex_code,
                            b.size,
                            b.config_image1,
                            b.color_name,
                            c.product_name,
                            c.product_img,
                            c.stock_status,
                            c.drop_shipping,
                            d.*,
                            e.state_title,
                            f.dist_name,
                            g.number,
                            g.username,
                            g.email
                        FROM
                            tbl_orders AS a
                        INNER JOIN tbl_order_item AS b
                        ON
                            a.order_id = b.order_id
                        INNER JOIN $tableName AS c
                        ON
                            b.prod_id = c.prod_id
                        INNER JOIN tbl_user_address AS d
                        ON
                            a.add_id = d.add_id
                        INNER JOIN tbl_state AS e
                        ON
                            e.state_id = d.state_id
                        INNER JOIN tbl_district AS f
                        ON
                            f.dist_id = d.dist_id
                        INNER JOIN tbl_users AS g
                        ON
                            g.user_id = d.user_id
                        WHERE
                            a.flag = 1 AND b.order_id = ? AND c.prod_id = ? AND d.default_addr = 1 AND d.flag = 1;";



            $itemRes = $db->query($itemQuery, [$orderID, $prodID])->getRowArray();



            if ($itemRes) {
                $itemRes['actual_price'] = $mrp;
                $itemRes['offer_price'] = $offerPrice;
                $itemRes['offer_type'] = $offerType;
                $itemRes['offer_details'] = $offerDetails;
                $data[] = $itemRes;
            }

        }

        $orderSummaries[$orderID] = $data;

        $res = $orderSummaries[$orderID];

        echo json_encode($res);
    }

    public function deleteOrderDetails()
    {
        $db = \Config\Database::connect();

        $orderID = $this->request->getPost('order_id');



        $query = "UPDATE tbl_orders SET `flag` = 0 WHERE `order_id` = ?";
        $dltData = $db->query($query, $orderID);

        $affectedRows = $db->affectedRows();

        if ($dltData && $affectedRows) {
            $result['code'] = 200;
            $result['msg'] = 'Product Deleted!!';
            $result['status'] = 'success';


            echo json_encode($result);
        } else {
            $result['code'] = 400;
            $result['msg'] = 'Something Wrong';
            $result['status'] = 'failure';

            echo json_encode($result);
        }
    }

    function updateTrackingDetails()
    {
        $db = \Config\Database::connect();
        $data = $this->request->getpost();


        $deliveryDate = $this->request->getpost('delivery_date');
        $courierPartner = $this->request->getpost('courier_partner');
        $trackingID = $this->request->getpost('tracking_id');
        $couponCode = $this->request->getpost('coupon_code');
        $orderId = $this->request->getpost('order_id');
        $bill_no = $this->request->getpost('bill_no');
        $bill_date = $this->request->getpost('bill_date');



        $query = "UPDATE tbl_orders SET delivery_date=?, courier_partner = ? ,tracking_id = ?,coupon_code = ?,bill_no = ?,bill_date = ?
                  WHERE order_id  = ? AND flag  = 1";
        $updateOrder = $db->query($query, [$deliveryDate, $courierPartner, $trackingID, $couponCode, $bill_no, $bill_date, $orderId]);
        $affectedRows = $db->affectedRows();


        if ($affectedRows) {
            $res['code'] = 200;
            $res['status'] = "success";
            $res['msg'] = "Data updated successfully";
        } else {
            $res['code'] = 400;
            $res['status'] = "failure";
            $res['msg'] = "Data updated failed";
        }
        echo json_encode($res);

    }

    public function getTrackingDetails()
    {
        $db = \Config\Database::connect();
        $orderID = $this->request->getPost("order_id");

        $query = "SELECT  `delivery_date` ,`delivery_message` , `courier_partner` ,`bill_no`,`bill_date`,
                  `tracking_id` , `coupon_code`  FROM `tbl_orders` WHERE `flag` = 1 AND `order_id` = ?";

        $res['track_detail'] = $db->query($query, [$orderID])->getResultArray();

        $res['code'] = 200;
        $res['status'] = 'success';

        echo json_encode($res);
    }


    public function viewTrackingDetails()
    {
        $db = \Config\Database::connect();
        $orderID = $this->request->getPost("order_id");

        $query = "SELECT  `delivery_date` ,`delivery_message` , `courier_partner` , `bill_no`,
        `bill_date`,  `tracking_id` , `coupon_code`  FROM `tbl_orders`
         WHERE `flag` = 1 AND `order_id` = ?";


        $res = $db->query($query, [$orderID])->getResultArray();
        echo json_encode($res);

    }


    public function updateCancelReason()
    {
        $db = \Config\Database::connect();
        $data = $this->request->getPost();


        $delivery_status = $this->request->getPost('delivery_status');
        $order_id = $this->request->getPost('order_id');
        $cancelReason = $this->request->getPost('cancelReason');
        $delivery_message = 6;


        $query = "UPDATE tbl_orders SET 
                    delivery_status = ?, 
                    delivery_message = ?,
                    cancel_reason = ?";

        $params = [$delivery_status, $delivery_message, $cancelReason];


        $query .= " WHERE order_id = ?";
        $params[] = $order_id;

        $update = $db->query($query, $params);
        $affectedRows = $db->affectedRows();

        if ($affectedRows) {
            $res['code'] = 200;
            $res['status'] = "success";
            $res['msg'] = "Data updated successfully";
        } else {
            $res['code'] = 400;
            $res['status'] = "failure";
            $res['msg'] = "Data updated failed";
        }
        echo json_encode($res);
    }

    public function updateDeliveryStatus()
    {
        $db = \Config\Database::connect();

        $data = $this->request->getPost();


        $order_id = $this->request->getPost('order_id');
        $delivery_status = $this->request->getPost('delivery_status');



        $query = "UPDATE tbl_orders SET 
                    delivery_status = ?, 
                    delivery_message = ?";


        $params = [$delivery_status, $delivery_status];


        if ($delivery_status == 2) {
            $query .= ", order_date = NOW()";
        } elseif ($delivery_status == 3) {
            $query .= ", process_date = NOW()";
        } elseif ($delivery_status == 4) {
            $query .= ", shipped_date = NOW()";
        } elseif ($delivery_status == 5) {
            $query .= ", delivery_date = NOW()";

        }


        $query .= " WHERE order_id = ?";
        $params[] = $order_id;

        $update = $db->query($query, $params);
        $affectedRows = $db->affectedRows();

        if ($affectedRows) {
            $res['code'] = 200;
            $res['status'] = "success";
            $res['msg'] = "Data updated successfully";
        } else {
            $res['code'] = 400;
            $res['status'] = "failure";
            $res['msg'] = "Data updated failed";
        }
        echo json_encode($res);
    }

    public function updateOrderPendingStatus()
    {
        $db = \Config\Database::connect();

        $razorpayKey = $_ENV['RAZORPAY_KEY_ID'];
        $razorpaySecret = $_ENV['RAZORPAY_KEY_SECRET'];

        $orderID = $this->request->getPost('order_id');
        $orderStatus = $this->request->getPost('delivery_status');


        $getOrderPendingLog = $db->query("
        SELECT `user_id`, `rzporder_id` 
        FROM `payment_orderpending_log` 
        WHERE `flag` = 1 AND `order_id` = ?",
            [$orderID]
        )->getRowArray();


        if (!$getOrderPendingLog) {
            return $this->response->setJSON([
                'code' => 400,
                'status' => 'failure',
                'msg' => 'No orders Found!!'
            ]);
        }

        $rzp_OrderID = $getOrderPendingLog['rzporder_id'];


        if (!$rzp_OrderID) {
            return $this->response->setJSON([
                'code' => 400,
                'status' => 'failure',
                'msg' => 'Razorpay OrderID not Found!!'
            ]);
        }

        try {
            $url = "https://api.razorpay.com/v1/orders/" . $rzp_OrderID;

            $client = \Config\Services::curlrequest();
            $response = $client->request('get', $url, [
                'auth' => [$razorpayKey, $razorpaySecret],
                'http_errors' => false
            ]);

            $orderData = json_decode($response->getBody(), true);
            $orderStatus = $orderData['status'] ?? null;

            if ($orderStatus === 'created') {
                return $this->response->setJSON([
                    'code' => 400,
                    'status' => 'pending',
                    'msg' => 'Cancel the order - User opened the payment page but did not complete payment.',


                ]);
            }

            return $this->uniqueOrderDetails($rzp_OrderID, $razorpayKey, $razorpaySecret);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'code' => 500,
                'status' => 'error',
                'msg' => $e->getMessage()
            ]);
        }
    }


    private function uniqueOrderDetails($razorpay_order_id, $razorpayKey, $razorpaySecret)
    {

        $db = \Config\Database::connect();
        $tallyModal = new ProductTallyMappingModel();
        try {
            $url = "https://api.razorpay.com/v1/orders/" . $razorpay_order_id . "/payments";

            $client = \Config\Services::curlrequest();
            $response = $client->request('get', $url, [
                'auth' => [$razorpayKey, $razorpaySecret],
                'http_errors' => false
            ]);

            $paymentData = json_decode($response->getBody(), true);


            if (empty($paymentData['items'])) {
                return $this->response->setJSON([
                    'code' => 200,
                    'status' => 'pending',
                    'msg' => 'No payments made yet for this order.'
                ]);
            }


            foreach ($paymentData['items'] as $payment) {
                $status = $payment['status'];
                $amount = $payment['amount'] / 100;
                $payment_method = $payment['method'];
                $razorpay_payment_id = $payment['id'];
                $orderID = $payment['notes']['order_id'];


                if ($status === 'captured') {
                    // to get orderID,Userid 
                    $orderDetails = $this->fetchOrderDetails($razorpay_order_id, $razorpaySecret);


                    $userID = $orderDetails['notes']['user_id'];
                    $orderID = $orderDetails['notes']['order_id'];
                    $username = $orderDetails['notes']['username'];



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
                    $orderstatus = 'success';
                    $orderQry = "UPDATE tbl_orders SET razerpay_payment_id = ?,razerpay_order_id = ?,order_status = ? ,delivery_message = ?,delivery_status = ?,payment_status = ?,payment_method = ? WHERE order_id = ?";
                    $updateData = $db->query($orderQry, [$razorpay_payment_id, $razorpay_order_id, $orderstatus, $deliveryMsg, $deliveryStatus, $payment_status, $payment_method, $orderID]);

                    $affectedRows = $db->affectedRows();

                    if ($affectedRows > 0) {
                        $result['code'] = 200;
                        $result['status'] = 'success';
                        $result['message'] = "Order updated as a new order.";
                        return $this->response->setJSON($result);
                    } else {
                        $result['code'] = 400;
                        $result['status'] = 'failure';
                        $result['message'] = "Order update failed - Captured";
                        return $this->response->setJSON($result);
                    }


                } elseif ($status === 'authorized') {

                    $Orderstatus = 'Pending';
                    $razorpay_signature = "NULL";

                    $orderID = session()->get('order_id');
                    $deliveryMsg = "Your order is pending.";
                    $deliveryStatus = 1;
                    $payment_status = 1;
                    $orderQry = "UPDATE tbl_orders SET razerpay_payment_id = ?,razerpay_order_id = ?,order_status = ? ,
						 delivery_message = ?,delivery_status = ?,payment_status = ? WHERE order_id = ?";
                    $updateData = $db->query($orderQry, [$razorpay_payment_id, $razorpay_order_id, $Orderstatus, $deliveryMsg, $deliveryStatus, $payment_status, $orderID]);
                    $affectedRows = $db->affectedRows();
                    if ($affectedRows > 0) {
                        $result['code'] = 200;
                        $result['status'] = 'success';
                        $result['message'] = "Payment authorized but not captured yet.";
                        return $this->response->setJSON($result);
                    } else {
                        $result['code'] = 400;
                        $result['status'] = 'failure';
                        $result['message'] = "Order update failed - Authorize";
                        return $this->response->setJSON($result);
                    }


                } elseif ($status === 'failed') {

                    $Orderstatus = 'Failure';
                    $razorpay_signature = "NULL";
                    $cancelReason = "Payment was unsuccessful";

                    $deliveryMsg = 6;
                    $deliveryStatus = 6;
                    $payment_status = 3;
                    $orderQry = "UPDATE tbl_orders SET razerpay_payment_id = ?,razerpay_order_id = ?,order_status = ? ,
		             delivery_message = ?,delivery_status = ?,payment_status = ? ,cancel_reason = ? WHERE order_id = ?";
                    $updateData = $db->query($orderQry, [$razorpay_payment_id, $razorpay_order_id, $Orderstatus, $deliveryMsg, $deliveryStatus, $payment_status, $cancelReason, $orderID]);

                    $affectedRows = $db->affectedRows();
                    if ($affectedRows > 0) {
                        $result['code'] = 200;
                        $result['status'] = 'success';
                        $result['message'] = "Payment Failure - Order cancelled.";
                        return $this->response->setJSON($result);
                    } else {
                        $result['code'] = 400;
                        $result['status'] = 'failure';
                        $result['message'] = "Order update failed - Failure.";
                        return $this->response->setJSON($result);
                    }

                }
            }

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'code' => 500,
                'status' => 'error',
                'msg' => $e->getMessage()
            ]);
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




    public function filterOrders()
    {
        $db = \Config\Database::connect();
        $filterDate = $this->request->getPost("filter_date");

        $query = "SELECT
                    a.*,
                    b.*,
                    DATE_FORMAT(a.order_date, '%d-%m-%Y') AS DATE,
                    CASE WHEN a.order_time IS NULL OR a.order_time = '0000-00-00 00:00:00' THEN '00:00:00' ELSE DATE_FORMAT(a.order_time, '%h:%i %p')
                END AS order_time,
                CASE WHEN a.`delivery_date` IS NULL OR a.delivery_date = '' THEN '-' ELSE DATE_FORMAT(a.delivery_date, '%d-%m-%Y')
                END AS deliverydate
                FROM
                    tbl_orders AS a
                INNER JOIN tbl_users AS b
                ON
                    a.`user_id` = b.user_id
                WHERE
                    a.flag = 1 AND b.flag = 1 AND DATE(a.log) = ?";

        $result = $db->query($query, [$filterDate])->getResultArray();


        echo json_encode($result);
    }

    public function checkPayment()
    {
        $db = \Config\Database::connect();
        $orderID = $this->request->getPost("orderID");

        $qry = "SELECT  `razerpay_payment_id`, `razerpay_order_id` ,`razerpay_signature` FROM `tbl_orders` WHERE flag = 1 
                AND order_id = ?";
        $orderDetails = $db->query($qry, [$orderID])->getResultArray();
        $razorpay_order_id = $orderDetails[0]['razerpay_order_id'];
        $razorpay_payment_id = $orderDetails[0]['razerpay_payment_id'];

        $key_id = $_ENV['RAZORPAY_KEY_ID'];
        $secret = $_ENV['RAZORPAY_KEY_SECRET'];

        $api = new Api($_ENV['RAZORPAY_KEY_ID'], $secret);
        $payment = $api->payment->fetch($razorpay_payment_id);


        $paymentStatus = $payment->status;
        $method = $payment->method;

        if ($paymentStatus === "captured") {

            $deliveryMsg = 1;
            $deliveryStatus = 1;
            $payment_status = 2;
            $orderstatus = "success";

            $orderQry = "UPDATE tbl_orders SET order_status = ? ,delivery_message = ?,delivery_status = ?,payment_status = ?,payment_method = ? WHERE order_id = ?";
            $updateData = $db->query($orderQry, [$orderstatus, $deliveryMsg, $deliveryStatus, $payment_status, $method, $orderID]);

            $affectedRows = $db->affectedRows();
            if ($affectedRows === 1) {
                $res['code'] = 200;
                $res['status'] = "success";
                $res['msg'] = "Payment Success";
            } else {
                $res['code'] = 400;
                $res['status'] = "failure";
                $res['msg'] = "Payment Failure";
            }
            echo json_encode($res);
        } else if ($paymentStatus === "pending") {
            $res['code'] = 400;
            $res['status'] = "failure";
            $res['msg'] = "Paymet Pending";
        }

    }

    public function pdfViewpage($segment)
    {

        $db = \Config\Database::connect();
        $orderID = base64_decode($segment);



        $query = "SELECT * FROM `tbl_order_item` WHERE `flag` = 1 AND `order_id` = ?";
        $itemDetails = $db->query($query, [$orderID])->getResultArray();


        $data = [];

        for ($i = 0; $i < count($itemDetails); $i++) {

            $prodID = $itemDetails[$i]['prod_id'];
            $tableName = $itemDetails[$i]['table_name'];
            $color = $itemDetails[$i]['color'];
            $hexCode = $itemDetails[$i]['hex_code'];
            $size = $itemDetails[$i]['size'];

            $itemQuery = "SELECT a.order_id,a.order_no,a.sub_total,a.courier_charge,a.order_status,a.log as order_time,a.order_date,a.razerpay_payment_id,
            a.payment_status,a.delivery_status,a.cancel_reason,a.courier_type,
            b.`quantity`, b.`prod_price`, b.`sub_total` AS product_price, 
            b.color,b.hex_code,b.size,b.config_image1,b.color_name,b.color_name,c.product_name, c.product_price AS actual_price,c.offer_price,c.offer_type,c.offer_details,
            c.product_img, c.stock_status, d.*,e.state_title ,f.dist_name,g.number,g.username,g.email
                        FROM tbl_orders AS a 
                        LEFT JOIN tbl_order_item AS b ON a.order_id = b.order_id 
                        INNER JOIN $tableName AS c ON b.prod_id = c.prod_id
                        INNER JOIN tbl_user_address AS d ON a.add_id = d.add_id
                        INNER JOIN tbl_state AS e ON e.state_id = d.state_id
                        INNER JOIN tbl_district  AS f  ON f.dist_id = d.dist_id
                        INNER JOIN tbl_users AS g ON g.user_id = d.user_id
                        WHERE d.default_addr = 1 AND d.flag = 1 
                          AND b.order_id = ? AND c.prod_id = ? AND c.flag = 1 AND a.flag = 1 AND b.color =? AND
                        b.hex_code =? AND b.size = ?";


            $itemRes = $db->query($itemQuery, [$orderID, $prodID, $color, $hexCode, $size])->getRowArray();

            if ($itemRes) {
                $data[] = $itemRes;
            }

        }


        $orderSummaries[$orderID] = $data;

        $res['data'] = $orderSummaries[$orderID];
        ob_start();
        $dompdf = new Dompdf();
        $dompdf->set_option('isRemoteEnabled', true);
        $html = view('orderPDF', $res);
        $dompdf->loadHtml($html);
        $dompdf->render();

        // Clear output buffer
        ob_clean();

        header("Cache-Control: maxage=1");
        header("Pragma: public");
        header("Content-type: application/pdf");
        header("Content-Disposition: inline; filename=order_$orderID.pdf");
        header("Content-Description: OrderList Data");
        header("Content-Transfer-Encoding: binary");

        // Clear output buffer again and flush
        ob_clean();
        flush();
        $output = $dompdf->output();

        // file_put_contents("./pdfs/order_$orderID.pdf", $output);
        echo $output;
        exit;



    }

    public function printPdf($orderID)
    {

        $data['pdfUrl'] = base_url() . "/pdfs/order_$orderID.pdf";

        return view('admin/print_pdf', $data);
    }


    public function processRefund()
    {

        $db = \Config\Database::connect();
        $getData = $this->request->getPost();


        $payment_id = $this->request->getPost('payment_id');
        $order_id = $this->request->getPost('order_id');
        $amount_type = $this->request->getPost('amount_type');



        $query = "SELECT `sub_total`,`courier_charge`  FROM `tbl_orders` WHERE flag =1 AND `order_id` =  ?";
        $getData = $db->query($query, [$order_id])->getRow();


        $ToalAmt = $getData->sub_total;
        $courierCharge = $getData->courier_charge;


        $total = (int) $ToalAmt;
        $courier = (int) $courierCharge;


        if ($amount_type == 0) {
            $RefundAmt = $total - $courier;
        } else if ($amount_type == 1) {
            $RefundAmt = $total;
        }

        $refund = (int) ($RefundAmt);




        if ($refund > $total) {


            return json_encode([
                'error' => [
                    'code' => 'BAD_REQUEST_ERROR',
                    'description' => 'The total refund amount is greater than the refund payment amount',
                    'source' => 'NA'
                ]
            ]);
        } else {

            $data = [
                'amount' => $RefundAmt * 100
            ];

            $url = "https://api.razorpay.com/v1/payments/" . $payment_id . "/refund";

            $api_key = $_ENV['RAZORPAY_KEY_ID'];
            $api_secret = $_ENV['RAZORPAY_KEY_SECRET'];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERPWD, $api_key . ":" . $api_secret);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

            $response = curl_exec($ch);

            if (curl_errno($ch)) {
                echo 'Error: ' . curl_error($ch);
            } else {
                $response_data = json_decode($response, true);


                if (isset($response_data['id']) && in_array($response_data['status'], ['created', 'processed'])) {
                    $deliveryStatus = ($response_data['status'] == 'created') ? 7 : 8;
                    $deliveryMessage = $deliveryStatus;
                    $refundID = $response_data['id'];
                    $refundAmt = $response_data['amount'];

                    $totalRefund = $refundAmt / 100;



                    $query = "UPDATE tbl_orders SET `delivery_status` = ?, `delivery_message` = ?, `refund_id` = ?,`refund_amt` = ? WHERE order_id = ?";
                    $UpdateStatus = $db->query($query, [$deliveryStatus, $deliveryMessage, $refundID, $totalRefund, $order_id]);

                    if ($db->affectedRows() == 1) {
                        $res['code'] = 200;
                        $res['message'] = 'Refund is' . $response_data['status'];
                        $res['status'] = 'success';
                    }
                    echo json_encode($res);
                } elseif (isset($response_data['id']) && $response_data['status'] == 'failed') {
                    // Handle failed refunds
                    $deliveryStatus = 9;
                    $deliveryMessage = 9;
                    $refundID = $response_data['id'];
                    $refundAmt = $response_data['amount'];

                    $query = "UPDATE tbl_orders SET `delivery_status` = ?, `delivery_message` = ?, `refund_id` = ?, `refund_amt` = ? WHERE order_id = ?";
                    $UpdateStatus = $db->query($query, [$deliveryStatus, $deliveryMessage, $refundID, $refundAmt / 100, $order_id]);

                    if ($db->affectedRows() == 1) {
                        $res['code'] = 400;
                        $res['message'] = 'Refund Failed';
                        $res['status'] = 'error';
                    }
                    echo json_encode($res);
                } else {

                    $res['code'] = 400;
                    $res['message'] = "Refund failed: " . $response_data['error']['description'];
                    $res['status'] = 'failure';
                    echo json_encode($res);
                }

            }
            curl_close($ch);

        }
    }


    public function checkRefundStatus()
    {
        $db = \Config\Database::connect();

        $orderID = $this->request->getPost('order_id');


        $query = "SELECT `refund_id`  FROM `tbl_orders` WHERE `order_id` = ?";
        $getRefund = $db->query($query, [$orderID])->getRow();


        $refundID = $getRefund->refund_id;

        try {

            $refund = $this->api->refund->fetch($refundID);

            if ($refund) {
                $refundStatus = $refund['status'];

                if ($refundStatus == 'processed') {
                    $deliveryStatus = 8;
                    $deliveryMessage = 8;
                } else if ($refundStatus == 'failed') {
                    $deliveryStatus = 9;
                    $deliveryMessage = 9;
                } else if ($refundStatus == 'created') {
                    $deliveryStatus = 7;
                    $deliveryMessage = 7;
                }

                $query = "UPDATE tbl_orders SET `delivery_status` = ?, `delivery_message` = ? WHERE order_id = ? AND `refund_id` = ?";
                $UpdateStatus = $db->query($query, [$deliveryStatus, $deliveryMessage, $orderID, $refundID]);

                $affectedRows = $db->affectedRows();

                if ($affectedRows == 1) {
                    $res['code'] = 200;
                    $res['message'] = 'Updated Successfully';
                    $res['status'] = 'success';
                } else {
                    $res['code'] = 400;
                    $res['message'] = 'Updated Failed';
                    $res['status'] = 'failure';
                }

            }

            return json_encode($res);
        } catch (\Exception $e) {
            $res['code'] = 400;
            $res['message'] = $e->getMessage();
            $res['status'] = 'failure';
            return json_encode($res);
        }

    }

}