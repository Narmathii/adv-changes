<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\OrdersModel;
use App\Models\BuynowModel;


class BuynowController extends BaseController
{

    public function buyNowView()
    {
        $this->session = \Config\Services::session();


        $db = \Config\Database::connect();
        $res['brand_master'] = $db->query('SELECT * FROM `brand_master` WHERE  `flag` =1 ORDER BY brand_name ASC')->getResultArray();
        $res['brand'] = $db->query('SELECT `brand_id`,UPPER(`brand_name`) AS `brand_name` ,`brand_img` FROM `tbl_brand_master` WHERE  `flag` =1 ORDER BY brand_name ASC')->getResultArray();
        $res['modal'] = $db->query('SELECT `modal_id` ,`brand_id`, CONCAT(UPPER(SUBSTRING(modal_name, 1, 1)), LOWER(SUBSTRING(modal_name, 2))) AS `modal_name` FROM `tbl_modal_master` WHERE  `flag` = 1 ORDER BY modal_name ASC ')->getResultArray();

        $res['accessories'] = $db->query('SELECT `access_id`, UPPER(`access_title`) AS `access_title`  FROM `tbl_access_master` WHERE `flag` = 1  ORDER BY  `access_title` ASC;')->getResultArray();
        $res['sub_accessories'] = $db->query('SELECT `sub_access_id`,`access_id`, CONCAT(UPPER(SUBSTRING(`sub_access_name`, 1, 1)), LOWER(SUBSTRING(`sub_access_name`, 2))) AS `sub_access_name`  FROM `tbl_subaccess_master` WHERE `flag` = 1 ORDER BY sub_access_name ASC;')->getResultArray();

        $res['riding_menu'] = $db->query('SELECT `r_menu_id` , UPPER(`r_menu`) AS `r_menu`  FROM `tbl_riding_menu` WHERE `flag` =1 ORDER BY r_menu ASC;')->getResultArray();
        $res['riding_submenu'] = $db->query('SELECT `r_sub_id`,`r_menu_id`,CONCAT(UPPER(SUBSTRING(`r_sub_menu`, 1, 1)), LOWER(SUBSTRING(`r_sub_menu`, 2))) AS `r_sub_menu`  FROM `tbl_riding_submenu` WHERE flag =1 ORDER BY r_sub_menu ASC')->getResultArray();

        $res['lug_menu'] = $db->query('SELECT `lug_menu_id`,UPPER(`lug_menu`) AS `lug_menu`  FROM `tbl_luggage_menu` WHERE  `flag` = 1 ORDER BY lug_menu')->getResultArray();
        $res['lud_submenu'] = $db->query('SELECT `lug_submenu_id`,`lug_menu_id`,CONCAT(UPPER(SUBSTRING(`lug_submenu`, 1, 1)), LOWER(SUBSTRING(`lug_submenu`, 2))) AS `lug_submenu` FROM `tbl_luggage_submenu` WHERE  `flag` =1 ORDER BY lug_submenu ASC')->getResultArray();

        $res['h_menu'] = $db->query('SELECT `h_menu_id`,UPPER(`h_menu`) AS `h_menu` FROM `tbl_helmet_menu` WHERE `flag` = 1 ORDER BY h_menu ASC')->getResultArray();
        $res['h_submenu'] = $db->query('SELECT `h_submenu_id`,`h_menu_id`, CONCAT(UPPER(SUBSTRING(`h_submenu`, 1, 1)), LOWER(SUBSTRING(`h_submenu`, 2))) AS `h_submenu`,`hsubmenu_img`FROM `tbl_helmet_submenu` WHERE `flag` = 1 ORDER BY h_submenu ASC')->getResultArray();

        $res['h_submenu_list'] = $db->query('SELECT `h_submenu_id`,`h_menu_id`, CONCAT(UPPER(SUBSTRING(`h_submenu`, 1, 1)), LOWER(SUBSTRING(`h_submenu`, 2))) AS `h_submenu`,`hsubmenu_img`FROM `tbl_helmet_submenu` WHERE `flag` = 1 AND  `h_menu_id` = 2 ORDER BY h_submenu ASC')->getResultArray();

        $res['camp_menu'] = $db->query('SELECT `camp_menu_id` ,UPPER(`camp_menu`) AS `camp_menu` FROM `tbl_camping_menu` WHERE flag = 1 ORDER BY camp_menu ASC;')->getResultArray();
        $res['camp_submenu'] = $db->query('SELECT `c_submenu_id`,`camp_menuid`,  CONCAT(UPPER(SUBSTRING(`c_submenu`, 1, 1)), LOWER(SUBSTRING(`c_submenu`, 2))) AS `c_submenu`,`csubmenu_img` FROM `tbl_camping_submenu` WHERE flag = 1 ORDER BY `c_submenu` ASC')->getResultArray();



        // to get cart count 
        $userID = session()->get('user_id');

        $query = "SELECT * FROM tbl_user_cart WHERE user_id = ? AND flag =1";
        $usercount = $db->query($query, [$userID])->getResultArray();
        if ($usercount > 0) {
            $res['cart_count'] = sizeof($usercount);
        } else {
            $res['cart_count'] = 0;
        }
        // end cart count



        // GET ADDRESS DETAILS 
        $addressQry = "SELECT  a.* , b.state_title , c.dist_name,d.number,d.username FROM
        `tbl_user_address` AS a INNER JOIN tbl_state AS b ON a.`state_id` = b.state_id
        INNER JOIN tbl_district  AS c  ON a.`dist_id` = c.dist_id 
        INNER JOIN tbl_users AS d  ON d.user_id = a.user_id 
        WHERE a.`flag` = 1 AND a.`user_id` = ?";

        $res['address'] = $db->query($addressQry, [$userID])->getResultArray();


        $res['state'] = $db->query("SELECT `state_id`,`state_title` FROM `tbl_state` WHERE `flag` =1")->getResultArray();

        // to get wishlist count 
        $res['wishlist_count'] = $this->getWishlistCount();
        $res['user_id'] = session()->get('user_id');

        // buynow product 
        $query = "SELECT `table_name`,`prod_id` FROM `tbl_buynow` WHERE `flag`= 1 AND  user_id = ?";
        $getbuynowData = $db->query($query, [$userID])->getResultArray();

        $tableName = $getbuynowData[0]['table_name'];
        $prodID = $getbuynowData[0]['prod_id'];

        $query2 = "SELECT a.prod_id,a.product_name, a.product_price, a.offer_price, a.product_img,b.quantity,
        b.buynow_id,b.user_id,b.table_name,b.sub_total, b.color, b.hex_code, b.size,b.config_image1,
         c.color_name
        FROM $tableName AS a 
        INNER JOIN tbl_buynow AS b 
        ON a.prod_id = b.prod_id
        LEFT JOIN tbl_color AS c ON c.color_id = b.color
        WHERE b.flag = 1 AND a.prod_id = ? AND b.user_id =?";
        $res['buynow'] = $db->query($query2, [$prodID, $userID])->getResultArray();

        $res['courier_type'] = $db->query("SELECT courier_id, courier_name FROM tbl_couriers WHERE flag = 1")->getResultArray();


        // For Email
        $emailQry = "SELECT `email`  FROM `tbl_users` WHERE `user_id` = ?";
        $checkEmail = $db->query($emailQry, [$userID])->getResultArray();

        $res['email'] = $checkEmail[0]['email'];

        return view('buyNow', $res);
    }

    public function getWishlistCount()
    {
        $db = \Config\Database::connect();
        $userID = session()->get('user_id');

        $query = "SELECT * FROM tbl_wishlist WHERE user_id = ? AND flag =1";
        $usercount = $db->query($query, [$userID])->getResultArray();
        if (!empty($usercount)) {
            $res = sizeof($usercount);
        } else {
            $res = 0;
        }
        return $res;
    }


    public function buyProductsList()
    {

        $db = \Config\Database::connect();

        $buyModel = new BuynowModel;

        $this->session = \Config\Services::session();
        $data = $this->request->getPost();

        $size = $this->request->getPost('size');
        $configImage = $this->request->getPost('config_image1');
        $tblName = $this->request->getPost('table_name');
        $prod_id = $this->request->getPost('prod_id');
        $prod_price = $this->request->getPost('prod_price');
        $quantity = $this->request->getPost('quantity');

        $userID = $this->session->get('user_id');

        if ($size == "") {
            $size = 0;
        }

        // getOrginal Products Price 
        $q1 = "SELECT `offer_price` ,`quantity`  FROM $tblName WHERE  `flag` = 1 AND `prod_id` = ?";
        $getOriginalProducts = $db->query($q1, [$prod_id])->getRow();

        $OriginalPrice = $getOriginalProducts->offer_price;
        $OriginalQty = $getOriginalProducts->quantity;

        if ($prod_price == $OriginalPrice && $quantity <= $OriginalQty) {
            $finalProdPrice = $prod_price;
        } else {
            $finalProdPrice = $OriginalPrice;
        }

        $subTotal = $finalProdPrice * $quantity;

        $data = [
            'user_id' => $userID,
            'table_name' => $tblName,
            'prod_id' => $prod_id,
            'quantity' => $quantity,
            'prod_price' => $finalProdPrice,
            'sub_total' => $subTotal,
            'size' => $size,
            'config_image1' => $configImage,
        ];


        $sql = "SELECT * FROM tbl_buynow WHERE  flag = 1";
        $getResult = $db->query($sql)->getResultArray();



        if (count($getResult) > 0) {
            $dltOldData = $db->query("DELETE FROM tbl_buynow WHERE  flag = 1");

            if ($dltOldData) {

                $insertData = $buyModel->insert($data);
                $affectedRow = $db->affectedRows();


                if ($affectedRow == 1) {
                    $result['code'] = 200;
                    $result['msg'] = 'Data Inserted to table';
                    $result['status'] = 'success';
                } else {
                    $result['code'] = 400;
                    $result['status'] = 'Failed';
                    $result['msg'] = 'Something went wrong during insertion';
                }
            }

        } else {

            $insertData = $buyModel->insert($data);
            $affectedRow = $db->affectedRows();

            if ($affectedRow == 1) {
                $result['code'] = 200;
                $result['msg'] = 'Data Inserted to table';
                $result['status'] = 'success';
            } else {
                $result['code'] = 400;
                $result['status'] = 'Failed';
                $result['msg'] = 'Something went wrong during insertion';
            }
        }

        echo json_encode($result);

    }



    public function buyProducts()
    {

        $this->session = \Config\Services::session();
        $db = \Config\Database::connect();

        $orderModel = new OrdersModel;

        $random_number = mt_rand(1000, 9999);
        $orderNO = "AS2025" . $random_number;

        // price calculation
        $price = $this->request->getPost('prod_price');
        $qty = $this->request->getPost('quantity');
        $totalAmt = $price * $qty;

        $userID = session()->get('user_id');
        $getAddress = $db->query("SELECT `add_id` FROM `tbl_user_address` WHERE `user_id` = $userID  AND  `flag` =1 AND `default_addr` = 1")->getRow();


        $addID = $getAddress->add_id;

        $OrderData = [
            'order_no' => $orderNO,
            'user_id' => $userID,
            'sub_total' => $totalAmt,
            'add_id' => $addID,
            'order_status' => "initiated",
            'order_date' => date('d-m-Y'),
        ];

        $insertOrder = $orderModel->insert($OrderData);

        $OrderID = $db->insertID();
        $prodID = $this->request->getPost('prod_id');
        $tblName = $this->request->getPost('table_name');
        $qty = $this->request->getPost('quantity');
        $price = $this->request->getPost('prod_price');

        $subTotal = $price * $qty;

        if ($insertOrder) {
            $query = "INSERT INTO tbl_order_item (order_id, prod_id, table_name, quantity, prod_price, sub_total) 
            VALUES ('$OrderID'loginStatus, '$prodID', '$tblName', '$qty', '$price', '$subTotal')";
            $orderItem = $db->query($query);

            if ($orderItem) {
                $result["status"] = "success";
                $result["code"] = 200;
                $result["msg"] = "Order placed";
                echo json_encode($result);
            } else {
                $result["status"] = "success";
                $result["code"] = 400;
                $result["msg"] = "Errors while placing order";
                echo json_encode($result);
            }
        }

    }

    public function checkLogin()
    {
        $this->session = \Config\Services::session();
        $db = \Config\Database::connect();
        $this->session = \Config\Services::session();
        $prevURl = previous_url();


        $loginStatus = session()->get('loginStatus');
        if ($loginStatus == "NO") {
            session()->set('callback_url', $prevURl);
            $res['code'] = '400';
            $res['msg'] = 'signin';
            echo json_encode($res);
        } else {
            $res['code'] = '200';
            $res['msg'] = 'success';
            $res['msg'] = 'logged in ';
            echo json_encode($res);
        }

    }


    public function buynowCheckout()
    {
        $this->session = \Config\Services::session();
        $db = \Config\Database::connect();
        $orderModel = new OrdersModel;


        $data = $this->request->getPost();

        $totalAmt = $this->request->getPost('totalamt');
        $courierCharge = $this->request->getPost('courierCharge');


        $State = $this->request->getPost('stateid');
        $courierType = $this->request->getPost('courier_type');
        $userID = session()->get('user_id');


        $buynowQuery = "SELECT * FROM `tbl_buynow` WHERE `user_id` = ? AND `flag` = 1";
        $buynowData = $db->query($buynowQuery, [$userID])->getResultArray();

        if (empty($buynowData)) {
            return json_encode(['code' => 400, 'status' => false, '`message' => 'No product Selected!']);
        }

        $totalWeightKg = 0;
        $finalCourierCharge = 0;
        $OrderPrice = 0;


        foreach ($buynowData as $item) {
            $prodID = $item['prod_id'];
            $tblName = $item['table_name'];
            $buyQuantity = $item['quantity'];
            $buyPrice = $item['prod_price'];
            $buySubtotal = $item['sub_total'];

            // Fetch the original product details for validation
            $originalProductQuery = "SELECT `prod_id`, `quantity`, `offer_price`, `tbl_name`, `weight`      
                             FROM $tblName 
                             WHERE `prod_id` = ? AND `flag` = 1";
            $originalProductData = $db->query($originalProductQuery, [$prodID])->getRow();


            if (!$originalProductData) {
                return json_encode(['code' => 400, 'status' => false, 'message' => 'Invalid product.']);
            }

            $originalQty = $originalProductData->quantity;
            $originalPrice = $originalProductData->offer_price;
            $originalWeight = $originalProductData->weight;


            // Correct cart price and quantity if mismatched
            $finalPrice = ($buyPrice == $originalPrice) ? $buyPrice : $originalPrice;

            if ($buyQuantity <= $originalQty && $buyPrice == $originalPrice) {
                $OrderPrice += $buySubtotal;
            } else {
                $OrderPrice += $originalPrice * $buyQuantity;
            }


            // Calculate total weight
            if (!empty($originalWeight)) {
                $prodWeightKg = $originalWeight / 1000;
                $totalWeightKg += $buyQuantity * $prodWeightKg;
            }


            if ($courierType == 0) {
                $finalCourierCharge = 100;

            } else {
                // Fetch courier charge for the product
                $courierChargeQuery = "SELECT `charges` 
                FROM `tbl_courier_charges` 
                WHERE `flag` = 1 AND `state_id` = ? AND `active_sts` = 1 
                AND courier_id = ? AND dist_id = 0";
                $courierChargeData = $db->query($courierChargeQuery, [$State, $courierType])->getRow();

                if ($courierChargeData) {
                    $finalCourierCharge = $courierChargeData->charges;
                }
            }
        }

        if ($courierType == 0) {
            $totalcourier = $finalCourierCharge;

            // if ($totalWeightKg <= 1) {
            //     $totalcourierCharge = $totalcourier;
            // } else {

            //     $totalCharge = $totalcourier * ceil($totalWeightKg);
            //     $GST = 0.18;
            //     $totalChargee = $totalCharge;
            //     $total = $totalChargee + ($totalChargee * $GST);
            //     $finalTotal = ceil($total);

            //     if ($finalTotal != $courierCharge) {
            //         $totalcourierCharge = $finalTotal;
            //     } else {
            //         $totalcourierCharge = $finalTotal;
            //     }
            // }

            $totalcourierCharge = 0;

            $courier_type = "Standard Amount";

        } else {
            // Calculate courier charges based on total weight
            $courier_type = "Express";

            if ($totalWeightKg <= 1) {
                $totalCharge = $finalCourierCharge;
            } else {
                $totalCharge = $finalCourierCharge * ceil($totalWeightKg);
            }

            // Calculate GST and final total
            $GST = 0.18;
            $totalWithoutGST = $totalCharge + 10;
            $total = $totalWithoutGST + ($totalWithoutGST * $GST);
            $finalTotal = ceil($total);


            // check Courier charge
            if ($finalTotal != $courierCharge) {
                $totalcourierCharge = $finalTotal;
            } else {
                $totalcourierCharge = $courierCharge;
            }

        }

        $finalOrderPrice = $OrderPrice + $totalcourierCharge;

        // getCount of total Orders 
        $currentYear = date('Y');
        $prefix = "AS" . $currentYear;


        $orderTotalq = "SELECT COUNT(`order_id`) AS total_count  FROM `tbl_orders`";
        $orderTotalData = $db->query($orderTotalq)->getRow();


        $lastId = $orderTotalData->total_count ? $orderTotalData->total_count : 0;
        $nextOrder = $lastId + 1;

        $salt = strtoupper(substr(md5($nextOrder . time()), 0, 6));


        $orderNO = $prefix . $salt . str_pad($nextOrder, 6, '0', STR_PAD_LEFT);
        // end of total Orders 



        $getAddreess = $db->query("SELECT `add_id` FROM `tbl_user_address` WHERE `user_id` = $userID  AND  `flag` =1 AND `default_addr` = 1")->getRow();
        if (!$getAddreess->add_id) {
            return json_encode(['status' => false, 'message' => 'Default address not found!']);
        }

        $addID = $getAddreess->add_id;

        $verifyAmt = $finalOrderPrice - $finalCourierCharge;

        if ($verifyAmt <= 0) {

            $res['code'] = 400;
            $res['message'] = "Invalid Product Price";

            echo json_encode($res);
        } else {
            // Prepare corrected order data
            $OrderData = [
                'order_no' => $orderNO,
                'user_id' => $userID,
                'sub_total' => $finalOrderPrice,
                'add_id' => $addID,
                'order_status' => "initiated",
                'order_date' => date('d-m-Y'),
                'courier_charge' => $totalcourierCharge,
                'courier_type' => $courier_type,


            ];

            $insertOrder = $orderModel->insert($OrderData);
            $OrderID = $db->insertID();


            $sess = [
                'order_id' => $OrderID,
            ];
            $this->session->set($sess);

            $affectedRows = $db->affectedRows();

            if ($affectedRows) {
                $query = "SELECT a.buynow_id, a.`table_name`, a.`prod_id`, a.`quantity`, a.`prod_price`, a.`sub_total`,
                a.color,a.hex_code,a.size , a.config_image1, b.add_id 
                FROM `tbl_buynow` AS a 
                INNER JOIN tbl_user_address AS b ON a.`user_id` = b.user_id 
                WHERE a.flag = 1 AND b.flag = 1 AND a.user_id = $userID  AND b.default_addr = 1";

                $orderDatas = $db->query($query)->getResultArray();

                $affectedRows = 0;

                foreach ($orderDatas as $cartItem) {
                    $prodID = $cartItem['prod_id'];
                    $tblName = $cartItem['table_name'];
                    $qty = $cartItem['quantity'];
                    $prodPrice = $cartItem['prod_price'];
                    $subTotal = $cartItem['sub_total'];
                    $buyNowID = $cartItem['buynow_id'];
                    $color = $cartItem['color'];
                    $hex_code = $cartItem['hex_code'];
                    $size = $cartItem['size'];
                    $config_image1 = $cartItem['config_image1'];


                    $colorQry = "SELECT `color_name` FROM `tbl_color` WHERE `flag` = 1 AND `color_id` = ?";

                    $colorData = $db->query($colorQry, $color)->getRow();
                    $colorName = $colorData->color_name;

                    $prouductQry = "SELECT
                    `product_price` AS mrp ,
                                   `offer_price`,
                                   `offer_type`,
                                   `offer_details`
                                   FROM
                                      $tblName
                                   WHERE
                                   `flag` = 1 AND `prod_id` = ? AND `tbl_name` = ? ";
                    $productData = $db->query($prouductQry, [$prodID, $tblName])->getRow();

                    $offer_price = $productData->offer_price;
                    $offer_type = $productData->offer_type;
                    $offer_details = $productData->offer_details;
                    $mrp = $productData->mrp;


                    $query = "INSERT INTO tbl_order_item (order_id, prod_id, table_name, quantity, prod_price, sub_total, color, hex_code,color_name, size, config_image1,mrp,offer_type,offer_details,offer_price) 
                   VALUES ('$OrderID', '$prodID', '$tblName', '$qty', '$prodPrice', '$subTotal', '$color', '$hex_code','$colorName', '$size', '$config_image1','$mrp','$offer_type','$offer_details','$offer_price')";

                    $orderItem = $db->query($query);
                    $affectedRows = $db->affectedRows();


                    $affectedRows = $db->affectedRows();

                    if ($affectedRows === 1) {
                        $res['code'] = 200;
                        $res['message'] = "OrderPlaced";

                    } else {
                        $res['code'] = 400;
                        $res['message'] = "Error while place order";

                    }
                }
                echo json_encode($res);
            }
        }


    }


    public function courierCharge()
    {
        $db = \Config\Database::connect();
        $stateID = $this->request->getPost("state_id");
        $courierType = $this->request->getPost("courierType");
        $userID = session()->get("user_id");

        if ($courierType == 1) {
            $query = "SELECT `charges` FROM `tbl_courier_charges` WHERE `flag` = 1 AND `state_id` = ? AND `active_sts` = 1 AND courier_id = ?";
            $getCharge = $db->query($query, [$stateID, $courierType])->getRow();

            $charge = $getCharge->charges;

            $query = "SELECT * FROM `tbl_buynow` WHERE `flag` = 1 AND `user_id` = ?";
            $prodList = $db->query($query, [$userID])->getResultArray();


            $totalWeightKg = 0;
            foreach ($prodList as $prod) {
                $prodID = $prod['prod_id'];
                $tblName = $prod['table_name'];
                $quantity = $prod['quantity'];


                $query = "SELECT `weight` FROM $tblName WHERE `flag` = 1 AND `prod_id` = ? AND tbl_name = ?";
                $productQty = $db->query($query, [$prodID, $tblName])->getRow();

                if (!empty($productQty)) {
                    $prodWeight = $productQty->weight;
                    $prodKg = $prodWeight / 1000;

                    $totalWeightKg += $quantity * $prodKg;
                }
            }


            if ($totalWeightKg <= 1) {
                $totalCharge = $charge;
            } else {
                $totalCharge = $charge * ceil($totalWeightKg);

            }

            $GST = 0.18;
            $totalWithoutGST = $totalCharge + 10;
            $total = $totalWithoutGST + ($totalWithoutGST * $GST);
            $finalCharge = ceil($total);

        } else if ($courierType == 0) {

            // $query = "SELECT * FROM `tbl_buynow` WHERE `flag` = 1 AND `user_id` = ?";
            // $prodList = $db->query($query, [$userID])->getResultArray();


            // $totalWeightKg = 0;
            // foreach ($prodList as $prod) {
            //     $prodID = $prod['prod_id'];
            //     $tblName = $prod['table_name'];
            //     $quantity = $prod['quantity'];


            //     $query = "SELECT `weight` FROM $tblName WHERE `flag` = 1 AND `prod_id` = ? AND tbl_name = ?";
            //     $productQty = $db->query($query, [$prodID, $tblName])->getRow();

            //     if (!empty($productQty)) {
            //         $prodWeight = $productQty->weight;
            //         $prodKg = $prodWeight / 1000;

            //         $totalWeightKg += $quantity * $prodKg;
            //     }
            // }

            // if ($totalWeightKg <= 1) {
            //     $finalCharge = 100;
            // } else {
            //     $GST = 0.18;
            //     $totalCharge = 100 * ceil($totalWeightKg);
            //     $totalWithoutGST = $totalCharge;
            //     $total = $totalWithoutGST + ($totalWithoutGST * $GST);
            //     $finalCharge = ceil($total);

            // }

            $finalCharge = 0;
        }
        // $finalCharge = 1
        echo json_encode($finalCharge);
    }

}