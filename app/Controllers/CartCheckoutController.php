<?php

namespace App\Controllers;

use App\Models\OrdersModel;

class CartCheckoutController extends BaseController
{
    public function cartCheckout()
    {
        $this->session = \Config\Services::session();
        $db = \Config\Database::connect();
        $orderModel = new OrdersModel;

        $data = $this->request->getPost();

        $courierCharge = $this->request->getPost('courierCharge');
        $totalAmt = $this->request->getPost('totalamt');
        $State = $this->request->getPost('stateid');
        $courierType = $this->request->getPost('courier_type');


        // getCount of total Orders 
        $currentYear = date('Y');
        $prefix = "AS" . $currentYear;

        // getCount of total Orders 
        $orderTotalq = "SELECT COUNT(`order_id`) AS total_count  FROM `tbl_orders`";
        $orderTotalData = $db->query($orderTotalq)->getRow();


        $lastId = $orderTotalData->total_count ? $orderTotalData->total_count : 0;
        $nextOrder = $lastId + 1;

        $salt = strtoupper(substr(md5($nextOrder . time()), 0, 6));


        $orderNO = $prefix . $salt . str_pad($nextOrder, 6, '0', STR_PAD_LEFT);
        // end of total Orders 


        $userID = session()->get('user_id');

        // Fetch user cart data
        $cartQuery = "SELECT * FROM `tbl_user_cart` WHERE `user_id` = ? AND `flag` =1 ";
        $cartData = $db->query($cartQuery, [$userID])->getResultArray();


        if (empty($cartData)) {
            return json_encode(['code' => 400, 'status' => false, 'message' => 'Cart is empty!']);
        }

        $totalWeightKg = 0;
        $finalCourierCharge = 0;
        $OrderPrice = 0;

        // Iterate over cart items to validate and correct data

        // for price count - if any one of the product price is 0 then the count will increase 
        $price_count = 0;


        foreach ($cartData as $item) {
            $prodID = $item['prod_id'];
            $tblName = $item['table_name'];
            $cartQuantity = $item['quantity'];
            $cartPrice = $item['prod_price'];
            $cartSubtotal = $item['sub_total'];

            // Fetch the original product details for validation
            $originalProductQuery = "SELECT `prod_id`, `quantity`, `offer_price`, `tbl_name`, `weight` 
                             FROM $tblName 
                             WHERE `prod_id` = ?";
            $originalProductData = $db->query($originalProductQuery, [$prodID])->getRow();


            if (!$originalProductData) {
                return json_encode(['code' => 400, 'status' => false, 'message' => 'Invalid product in cart.']);
            }

            $originalQty = $originalProductData->quantity;
            $originalPrice = $originalProductData->offer_price;
            $originalWeight = $originalProductData->weight;

            // Correct cart price and quantity if mismatched
            $finalPrice = ($cartPrice == $originalPrice) ? $cartPrice : $originalPrice;


            if ($cartQuantity <= $originalQty && $cartPrice == $originalPrice && $cartPrice != 0 && $originalPrice != 0) {
                $OrderPrice += $cartSubtotal;

            } else if ($originalPrice == 0 && $cartPrice == 0 || $originalPrice == 0) {
                $price_count += 1;
                $OrderPrice += $originalPrice * $cartQuantity;
            } else {
                $OrderPrice += $originalPrice * $cartQuantity;
            }


            // Calculate total weight
            if (!empty($originalWeight)) {
                $prodWeightKg = $originalWeight / 1000;
                $totalWeightKg += $cartQuantity * $prodWeightKg;
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
            // $totalcourier = $finalCourierCharge;

            // if ($totalWeightKg <= 1) {
            //     $totalCharge = $totalcourier;
            // } else {
            //     $totalCharge = $totalcourier * ceil($totalWeightKg);
            // }

            // $GST = 0.18;
            // $totalChargee = $totalCharge;
            // $totalWithoutGST = $totalChargee;
            // $total = $totalWithoutGST + ($totalWithoutGST * $GST);

            // $finalTotal = ceil($total);

            // if ($finalTotal != $courierCharge) {
            //     $totalcourierCharge = $finalTotal;
            // } else {
            //     $totalcourierCharge = $finalTotal;
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

                $totalcourierCharge = $finalTotal;
            }
        }


        $finalOrderPrice = $OrderPrice + $totalcourierCharge;

        // Fetch default address for the user
        $addressQuery = "SELECT `add_id` 
                 FROM `tbl_user_address` 
                 WHERE `user_id` = ? AND `flag` = 1 AND `default_addr` = 1";
        $addressData = $db->query($addressQuery, [$userID])->getRow();

        if (!$addressData) {
            return json_encode(['status' => false, 'message' => 'Default address not found!']);
        }

        $addID = $addressData->add_id;


        $verifyAmt = $finalOrderPrice - $finalCourierCharge;

        if ($price_count > 0 || $verifyAmt <= 0) {
            $res['code'] = 400;
            $res['message'] = "Invalid Product Price";

            echo json_encode($res);
        } else {
            // Prepare corrected order data
            $orderData = [
                'order_no' => $orderNO,
                'user_id' => $userID,
                'sub_total' => $finalOrderPrice,
                'add_id' => $addID,
                'order_status' => "initiated",
                'order_date' => date('d-m-Y'),
                'courier_charge' => $totalcourierCharge,
                'courier_type' => $courier_type,

            ];

            $insertOrder = $orderModel->insert($orderData);
            $OrderID = $db->insertID();

            $sess = [
                'order_id' => $OrderID,
            ];
            $this->session->set($sess);



            $affectedRows = $db->affectedRows();

            if ($affectedRows == 1) {
                $query = "SELECT a.cart_id, a.`table_name`, a.`prod_id`, a.`quantity`, a.`prod_price`, a.`sub_total`,
                a.color,a.hex_code,a.size , a.config_image1, b.add_id 
                FROM `tbl_user_cart` AS a 
                INNER JOIN tbl_user_address AS b ON a.`user_id` = b.user_id 
                WHERE a.flag = 1 AND b.flag = 1 AND a.user_id = $userID  AND b.default_addr = 1";

                $cartData = $db->query($query)->getResultArray();


                $inner_affectedRows = 0;

                foreach ($cartData as $cartItem) {
                    $prodID = $cartItem['prod_id'];
                    $tblName = $cartItem['table_name'];
                    $qty = $cartItem['quantity'];
                    $prodPrice = $cartItem['prod_price'];
                    $subTotal = $cartItem['sub_total'];
                    $cartID = $cartItem['cart_id'];
                    $color = $cartItem['color'];
                    $hex_code = $cartItem['hex_code'];
                    $size = $cartItem['size'];
                    $config_image1 = $cartItem['config_image1'];

                    $colorQry = "SELECT `color_name` FROM `tbl_color` WHERE `flag` = 1 AND `color_id` = ?";

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

                    $colorData = $db->query($colorQry, $color)->getRow();

                    $offer_price = $productData->offer_price;
                    $offer_type = $productData->offer_type;
                    $offer_details = $productData->offer_details;
                    $mrp = $productData->mrp;

                    $colorName = $colorData->color_name;


                    $query = "INSERT INTO tbl_order_item (order_id, prod_id, table_name, quantity, prod_price, sub_total, color, hex_code,color_name, size, config_image1,mrp,offer_type,offer_details,offer_price) 
                    VALUES ('$OrderID', '$prodID', '$tblName', '$qty', '$prodPrice', '$subTotal', '$color', '$hex_code','$colorName', '$size', '$config_image1','$mrp','$offer_type','$offer_details','$offer_price')";

                    $orderItem = $db->query($query);
                    $inner_affectedRows = $db->affectedRows();


                    if ($inner_affectedRows == 1) {
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

    public function checkLoginRes()
    {
        $this->session = \Config\Services::session();
        $db = \Config\Database::connect();

        $loginStatus = session()->get('loginStatus');

        $previousURL = previous_url();
        $this->session->set('callback_url', $previousURL);

        if ($loginStatus == "NO") {
            $res['code'] = '400';
            $res['msg'] = 'signin';
            $res['prev_url'] = $previousURL;

        } else {
            $res['code'] = '200';
            $res['msg'] = 'success';

        }

        echo json_encode($res);

    }

}