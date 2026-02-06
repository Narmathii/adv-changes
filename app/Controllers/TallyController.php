<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class TallyController extends ResourceController
{
    protected $format = 'json';

    public function getTallyData($orderID)
    {

        // $incomingApiKey = $this->request->getHeaderLine('X-API-KEY');
        // $validApiKey = env('X-API-KEY');


        // if ($incomingApiKey !== $validApiKey) {
        //     return $this->response->setStatusCode(401)->setJSON([
        //         'status' => 'error',
        //         'message' => 'Unauthorized access'
        //     ]);
        // }

        try {
            $db = \Config\Database::connect();

            if ($orderID != 0) {

                $tallyData = "a.order_id ,";
                $finalTallyData = "SELECT DISTINCT
                                    `order_id`,
                                    `product_price`,
                                    `courier_charge`,
                                    `payment_status`,
                                    `tally_sync_status`,
                                    `customer_name`
                                FROM
                                    `tally_details`
                                WHERE
                                    flag = 1 AND `tally_sync_status` = 'pending'";

                $finalTallyData .= " AND `order_id` > $orderID";


            } else if ($orderID == 0) {
                $finalTallyData = "SELECT DISTINCT
                        `order_id`,
                        `product_price`,
                        `courier_charge`,
                        `payment_status`,
                        `tally_sync_status`,
                        `customer_name`
                    FROM
                        `tally_details`
                    WHERE
                        `flag` = 1 AND DATE(`log`) > '2025-04-04';
                    ";


            }

            $finalResult = $db->query($finalTallyData)->getResultArray();

            $finalData = [];
            foreach ($finalResult as $tallyData) {
                $orderID = $tallyData['order_id'];

                $sql = "SELECT `user_id`, `order_no` , `add_id`,`order_date`,`sub_total`,`courier_charge` FROM `tbl_orders` WHERE flag = 1 AND `order_id` = ?";
                $getOrderDetails = $db->query($sql, [$orderID])->getRow();



                $userID = $getOrderDetails->user_id;
                $orderDate = $getOrderDetails->order_date;
                $total_amt = $getOrderDetails->sub_total;
                $courier_charge = $getOrderDetails->courier_charge;
                $order_no = $getOrderDetails->order_no;


                $cust_qry = "SELECT
                                a.user_id,
                                a.`state_id`,
                                a.`dist_id`,
                                a.`landmark`,
                                a.`city`,
                                a.`address`,
                                a.`pincode`,
                                a.`default_addr`,
                                b.state_title,
                                c.dist_name,
                                d.number,d.email
                               
                            FROM
                                `tbl_user_address` AS a
                            INNER JOIN tbl_state AS b
                            ON
                                a.state_id = b.state_id
                            LEFT JOIN tbl_district AS c
                            ON
                                c.dist_id = a.dist_id
                            LEFT JOIN tbl_users AS d
                            ON
                                d.user_id = a.user_id
                           
                            WHERE
                                a.flag = 1 AND a.default_addr = 1 AND a.user_id = ?;";

                $get_cust_details = $db->query($cust_qry, [$userID])->getResultArray();


                $get_order_item = "SELECT * FROM `tbl_order_item` WHERE flag  = 1 AND `order_id` = ?;";
                $orderItem = $db->query($get_order_item, [$orderID])->getResultArray();




                $orderItems = [];
                foreach ($orderItem as $item) {
                    $prod_id = $item["prod_id"];
                    $tbl_name = $item['table_name'];
                    $color = $item['color'];
                    $size = $item['size'];
                    $mrp = $item['mrp'];
                    $offer_price = $item['offer_price'];
                    $offer_type = $item['offer_type'];
                    $offer_details = $item['offer_details'];


                    $item_query = "SELECT product_name ,`stock_status`  FROM $tbl_name WHERE flag = 1 AND prod_id = ?";
                    $item_datas = $db->query($item_query, [$prod_id])->getRow();

                    $offerTypee = $offer_type;
                    $offerType = $offerTypee == 0 ? 'Percentage' :
                        ($offerTypee == 1 ? 'Flat Discount' :
                            ($offerTypee == 2 ? 'None' : 'Invalid'));

                    $sizeVal = $size != 0 ? $size : 'n/a';
                    $colorVal = $color != 0 ? $color : 'n/a';

                    $shippingQuantity = $item['quantity'];

                    $final_data = [
                        "order_id" => $orderID,
                        "order_no" => $order_no,
                        "order_date" => $orderDate,
                        "customer_name" => $tallyData['customer_name'],
                        "product_name" => $item_datas->product_name,
                        "color" => $colorVal,
                        "size" => $sizeVal,
                        "product_price" => $mrp,
                        "offer_price" => $offer_price,
                        "offer_type" => $offerType,
                        "offer_details" => $offer_details,
                        "courier_charge" => $courier_charge,
                        "total_amount" => $total_amt,
                        "payment_status" => $tallyData['payment_status'],
                        "shipping_qty" => $shippingQuantity,
                        "tally_sync_status" => $tallyData['tally_sync_status'],
                        "customer_Address1" => $get_cust_details[0]['address'],
                        "customer_Address2" => $get_cust_details[0]['landmark'],
                        "customer_Address3" => $get_cust_details[0]['city'],
                        "customer_Address4" => $get_cust_details[0]['dist_name'],
                        "customer_state" => $get_cust_details[0]['state_title'],
                        "customer_pincode" => $get_cust_details[0]['pincode'],
                        "customer_phone" => $get_cust_details[0]['number'],
                        "customer_email" => $get_cust_details[0]['email'],
                        "Bill_From" => "Tamil Nadu",
                        "Ship_To" => $get_cust_details[0]['state_title']
                    ];
                    $finalData[] = $final_data;


                }

            }



            if (!empty($finalData)) {
                return $this->respond([
                    'message' => 'Data fetched successfully.',
                    'data' => $finalData
                ], 200);

            } else {
                return $this->respond(['message' => 'No pending data found for syncing.'], 200);
            }

        } catch (\Exception $e) {

            return $this->failServerError("Error occurred: " . $e->getMessage());
        }
    }


    public function updateTally()
    {
        ini_set('memory_limit', 512000000);
        ini_set('max_execution_time', 300);

        try {
            $data = $this->request->getBody();
            $jsonData = json_decode($data, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return $this->response->setStatusCode(400)->setJSON([
                    'code' => 400,
                    'message' => 'Error decoding JSON: ' . json_last_error_msg(),
                    'status' => 'Failure'
                ]);
            }

            if (!is_array($jsonData)) {
                return $this->response->setStatusCode(400)->setJSON([
                    'code' => 400,
                    'message' => 'Invalid JSON data received.',
                    'status' => 'Failure'
                ]);
            }

            $totalCount = count($jsonData['order_id'] ?? []);

            if ($totalCount == 0) {
                return $this->response->setStatusCode(400)->setJSON([
                    'code' => 400,
                    'message' => 'Order ID is empty',
                    'status' => 'Failure'
                ]);
            }

            $requestID = $jsonData['order_id'];
            $updated_OrderID = [];
            $db = \Config\Database::connect();

            foreach ($requestID as $orderID) {
                $query = "UPDATE `tally_details` SET `tally_sync_status` = 'sent' WHERE `order_id` = ?";
                $db->query($query, [$orderID]);

                $affectedRows = $db->affectedRows();

                if ($affectedRows) {
                    $updated_OrderID[] = $orderID;
                }
            }

            $array_count = count($updated_OrderID);

            if ($array_count > 0) {
                return $this->response->setStatusCode(200)->setJSON([
                    'code' => 200,
                    'status' => 'Success',
                    'message' => 'Status updated successfully.',
                    'updated_orderID' => $updated_OrderID
                ]);
            } else {
                return $this->response->setStatusCode(400)->setJSON([
                    'code' => 400,
                    'status' => 'Failure',
                    'message' => 'Order ID not found (or) Status alredy updated'
                ]);
            }

        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'code' => 500,
                'message' => 'Error occurred: ' . $e->getMessage(),
                'status' => 'Failure'
            ]);
        }
    }



    public function syncTallyData()
    {

        try {
            $jsonData = json_decode($this->request->getBody(), true);
            $db = \Config\Database::connect();
            $db->query("SET @source = 'tally'");
            $table_names = [
                'tbl_accessories_list',
                'tbl_rproduct_list',
                'tbl_helmet_products',
                'tbl_luggagee_products',
                'tbl_camping_products'
            ];

            $res = [];
            $updatedProducts = [];

            foreach ($jsonData as $item) {
                if (isset($item['item_name'], $item['quantity'])) {
                    $prodName = $item['item_name'];

                    $Tallystock = intval($item['quantity']);
                    if ($Tallystock < 0) {
                        $Tallystock = 0;
                    }


                    $updateProd = "";

                    // Search for product in all tables
                    foreach ($table_names as $table) {
                        // $query = $db->query(
                        //     "SELECT COUNT(prod_id) as count, prod_id, tbl_name, quantity FROM $table WHERE billing_name = ? AND flag = 1",
                        //     [$prodName]
                        // );
                        $query = $db->query(
                            "SELECT COUNT(prod_id) as count, prod_id, quantity ,tbl_name
                            FROM $table 
                            WHERE TRIM(LOWER(billing_name)) LIKE TRIM(LOWER(?)) AND flag = 1",
                            ["%" . strtolower(trim($prodName)) . "%"]
                        );

                        $result = $query->getRow();


                        if ($result && $result->count > 0) {
                            $updateProd = $result;
                            break;
                        }
                    }

                    if ($updateProd) {
                        // Update the product if found
                        $productID = $updateProd->prod_id;
                        $tableName = $updateProd->tbl_name;

                        if ($productID != '' && $tableName != '') {
                            $updateQuery = "UPDATE $tableName SET quantity = ? WHERE prod_id = ? AND flag = 1";
                            $db->query($updateQuery, [$Tallystock, $productID]);
                            $affecteRow = $db->affectedRows();



                            $updateData = [
                                'prod_id' => $productID,
                                'prod_name' => $prodName,
                                'quantity' => $Tallystock,
                                'tbl_name' => $tableName,
                            ];
                            $updatedProducts[] = $updateData; // Append to updated products list
                        }
                    } else if ($prodName) {
                        // Handle products with sizes
                        // $sizePattern = '/(?:^|[\s\-])(?:XS|S|M|L|XL|XXL|XXXL|4XL|5XL|6XL|7XL|8XL|9XL)(?=$|[\s\-])/';
                        // XS, S-XXXL, 4-9XL  **and** the numeric sizes 1-100
                        $sizePattern = '/(?:^|[\s\-])(?:[1-9]\d?|100|XS|S|M|L|XL|XXL|XXXL|[4-9]XL)(?=$|[\s\-])/i';

                        preg_match_all($sizePattern, $prodName, $matches);
                        $size = $matches[0];

                        if (empty($size)) {
                            continue;
                        }

                        $final_size = preg_replace('/-+/', ' ', $size);
                        $productName = preg_replace($sizePattern, '', $prodName);
                        $final_prodname = trim(preg_replace('/-+/', '-', $productName), '- ');



                        if ($final_prodname != '' && $final_size != '') {
                            foreach ($table_names as $table) {
                                $query_res = $db->query(
                                    "SELECT COUNT(*) as count, prod_id, tbl_name, quantity FROM $table WHERE billing_name = ? AND flag = 1",
                                    [$final_prodname]
                                )->getRow();

                                if ($query_res && $query_res->count > 0) {
                                    $getconfig_data = $query_res;
                                    break;
                                }
                            }

                            $Config_prodid = $getconfig_data->prod_id;
                            $Config_tblname = $getconfig_data->tbl_name;

                            $configqry = "SELECT * FROM `tbl_configuration` WHERE `prod_id` = ? AND tbl_name = ? AND `flag` = 1;";
                            $getRes = $db->query($configqry, [$Config_prodid, $Config_tblname])->getResultArray();

                            $configID = $getRes[0]['config_id'];
                            $newStockarray = [];

                            if (!empty($getRes)) {
                                $totalSize = str_replace(['[', ']', '"'], '', $getRes[0]['size']);
                                $totalStock = str_replace(['[', ']', '"'], '', $getRes[0]['soldout_status']);

                                $totalSize = explode(",", $totalSize);
                                $totalStock = explode(",", $totalStock);

                                for ($i = 0; $i < count($totalSize); $i++) {
                                    if (trim($totalSize[$i]) == trim($final_size[0])) {
                                        $newStockarray[$i] = (string) $Tallystock;
                                    } else {
                                        $newStockarray[$i] = $totalStock[$i];
                                    }
                                }
                            }

                            $Main_QTY = array_sum($newStockarray);
                            $updatedStock = json_encode($newStockarray);

                            $updateConfigqry = "UPDATE tbl_configuration SET soldout_status = ? WHERE config_id = ? AND tbl_name = ? AND prod_id = ? AND flag =1 ";
                            $updateConfig = $db->query($updateConfigqry, [$updatedStock, $configID, $Config_tblname, $Config_prodid]);

                            if ($db->affectedRows() > 0) {
                                $UpdateMainprod_qry = "UPDATE $Config_tblname SET quantity = ? WHERE prod_id = ? AND tbl_name = ? AND flag = 1";
                                $db->query($UpdateMainprod_qry, [$Main_QTY, $Config_prodid, $Config_tblname]);

                                if ($db->affectedRows() > 0) {
                                    $updatedProducts[] = [
                                        'prod_id' => $Config_prodid,
                                        'prod_name' => $final_prodname,
                                        'quantity' => $Main_QTY,
                                        'tbl_name' => $Config_tblname,
                                    ];
                                }
                            }
                        }
                    }
                }
            }

            if (!empty($updatedProducts)) {
                $res['code'] = 200;
                $res['status'] = 'Success';
                $res['message'] = 'Stock updated successfully.';
                $res['count'] = count($updatedProducts);
                // $res['updated_products'] = $updatedProducts;

            } else {
                $res['code'] = 400;
                $res['status'] = 'Failure';
                $res['message'] = 'No products were updated.';
            }


            echo json_encode($res);


        } catch (\Exception $e) {
            return ['code' => 500, 'message' => 'Error occurred: ' . $e->getMessage(), 'status' => 'Failure'];
        }
    }


}
