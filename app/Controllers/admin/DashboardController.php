<?php

namespace App\Controllers\admin;


class DashboardController extends BaseController
{

    public function shippingstatus()
    {
        $session = \Config\Services::session();
        $db = \Config\Database::connect();

        if ($session->get('login_sts') == "") {
            return redirect()->to('admin');
        } else {
            $query = "SHOW COLUMNS FROM tbl_orders LIKE 'delivery_status'";
            $result = $db->query($query)->getRow();


            if ($result) {
                // Extract ENUM values from the Type field
                preg_match("/^enum\((.*)\)$/", $result->Type, $matches);
                if (!empty($matches[1])) {
                    $enumValues = explode(",", str_replace("'", "", $matches[1]));
                    // return $enumValues;
                }
            }

            $res['delivery_sts'] = $enumValues;

            return view("admin/shippingstatus", $res);
        }

    }


    public function getshippingstatus()
    {
        $db = \Config\Database::connect();
        $query =

            "SELECT a.*, b.*, DATE_FORMAT(a.order_date, '%d-%m-%Y') AS date , 
            CASE
                WHEN a.order_time IS NULL OR a.order_time = '0000-00-00 00:00:00' THEN '00:00:00'
                ELSE DATE_FORMAT(a.order_time, '%h:%i %p')
            END AS order_time,   
            
            DATE_FORMAT(a.delivery_date, '%d-%m-%Y')  AS delivery_date FROM tbl_orders AS a INNER JOIN 
            tbl_users AS b ON a.`user_id` = b.user_id
            WHERE a.flag = 1 AND b.flag = 1 AND delivery_status = 4";
        $orderDetail = $db->query($query)->getResultArray();

        echo json_encode($orderDetail);
    }

    public function deliverystatus()
    {
        $session = \Config\Services::session();
        $db = \Config\Database::connect();

        if ($session->get('login_sts') == "") {
            return redirect()->to('admin');
        } else {
            $query = "SHOW COLUMNS FROM tbl_orders LIKE 'delivery_status'";
            $result = $db->query($query)->getRow();


            if ($result) {
                // Extract ENUM values from the Type field
                preg_match("/^enum\((.*)\)$/", $result->Type, $matches);
                if (!empty($matches[1])) {
                    $enumValues = explode(",", str_replace("'", "", $matches[1]));
                    // return $enumValues;
                }
            }

            $res['delivery_sts'] = $enumValues;

            return view("admin/deliverystatus", $res);
        }



    }

    public function getDeliverystatus()
    {
        $db = \Config\Database::connect();
        $query =

            "SELECT a.*, b.*, DATE_FORMAT(a.order_date, '%d-%m-%Y') AS date , 
            CASE
                WHEN a.order_time IS NULL OR a.order_time = '0000-00-00 00:00:00' THEN '00:00:00'
                ELSE DATE_FORMAT(a.order_time, '%h:%i %p')
            END AS order_time,   
            DATE_FORMAT(a.delivery_date, '%d-%m-%Y')  AS delivery_date  FROM tbl_orders AS a INNER JOIN 
            tbl_users AS b ON a.`user_id` = b.user_id
            WHERE a.flag = 1 AND b.flag = 1 AND delivery_status = 5";
        $orderDetail = $db->query($query)->getResultArray();
        echo json_encode($orderDetail);
    }


    public function notification()
    {
        $db = \Config\Database::connect();
        $res['stock_status'] = $db->query("SELECT `prod_id`, `product_name`, 'tbl_products' as `tbl_name`, `quantity`
                                FROM tbl_products
                                WHERE `flag` = 1 AND `quantity` <= 1
                                UNION 
                                SELECT `prod_id`, `product_name`, 'tbl_accessories_list' as `tbl_name`, `quantity`
                                FROM tbl_accessories_list
                                WHERE `flag` = 1 AND `quantity` <= 1
                                UNION 
                                SELECT `prod_id`, `product_name`, 'tbl_rproduct_list' as `tbl_name`, `quantity`
                                FROM tbl_rproduct_list
                                WHERE `flag` = 1 AND `quantity` <= 1
                                UNION 
                                SELECT `prod_id`, `product_name`, 'tbl_luggagee_products' as `tbl_name`, `quantity`
                                FROM tbl_luggagee_products
                                WHERE `flag` = 1 AND `quantity` <= 1
                                UNION 
                                SELECT `prod_id`, `product_name`, 'tbl_helmet_products' as `tbl_name`, `quantity`
                                FROM tbl_helmet_products
                                WHERE `flag` = 1 AND `quantity` <= 1
                                UNION 
                                SELECT `prod_id`, `product_name`, 'tbl_camping_products' as `tbl_name`, `quantity`
                                FROM tbl_camping_products
                                WHERE `flag` = 1 AND `quantity` <= 1
                                    ")->getResultArray();
        $res['stock_count'] = count($res['stock_status']);
        return view("admin/notification", $res);
    }


    public function getPendingOrder()
    {
        $db = \Config\Database::connect();
        $query =

            "SELECT a.*, b.*, DATE_FORMAT(a.order_date, '%d-%m-%Y') AS date ,
            CASE
                WHEN a.order_time IS NULL OR a.order_time = '0000-00-00 00:00:00' THEN '00:00:00'
                ELSE DATE_FORMAT(a.order_time, '%h:%i %p')
            END AS order_time, 
            
            DATE_FORMAT(a.delivery_date, '%d-%m-%Y')  AS delivery_date FROM tbl_orders AS a INNER JOIN 
            tbl_users AS b ON a.`user_id` = b.user_id
            WHERE a.flag = 1 AND a.delivery_status =  3 AND b.flag = 1
            ORDER BY `order_date` ASC";
        $orderDetail = $db->query($query)->getResultArray();
        echo json_encode($orderDetail);
    }


    public function pendingOrder()
    {
        $session = \Config\Services::session();
        $db = \Config\Database::connect();

        if ($session->get('login_sts') == "") {
            return redirect()->to('admin');
        } else {
            $query = "SHOW COLUMNS FROM tbl_orders LIKE 'delivery_status'";
            $result = $db->query($query)->getRow();


            if ($result) {
                // Extract ENUM values from the Type field
                preg_match("/^enum\((.*)\)$/", $result->Type, $matches);
                if (!empty($matches[1])) {
                    $enumValues = explode(",", str_replace("'", "", $matches[1]));
                    // return $enumValues;
                }
            }

            $res['delivery_sts'] = $enumValues;

            return view('admin/pendingorder', $res);
        }


    }

    public function canceledOrder()
    {
        $db = \Config\Database::connect();

        $query = "SELECT `delivery_status` FROM `tbl_orders` WHERE `flag` = 1";
        $res['del_status'] = $db->query($query)->getResultArray();

        $session = \Config\Services::session();

        if ($session->get('login_sts') == "") {
            return redirect()->to('admin');
        } else {
            $query = "SHOW COLUMNS FROM tbl_orders LIKE 'delivery_status'";
            $result = $db->query($query)->getRow();


            if ($result) {
                // Extract ENUM values from the Type field
                preg_match("/^enum\((.*)\)$/", $result->Type, $matches);
                if (!empty($matches[1])) {
                    $enumValues = explode(",", str_replace("'", "", $matches[1]));
                    // return $enumValues;
                }
            }

            $res['delivery_sts'] = $enumValues;
            return view('admin/canceledOrder', $res);
        }

    }


    public function getcancelledOrder()
    {
        $db = \Config\Database::connect();
        $query =
            "SELECT
            a.*,
            b.*,
            DATE_FORMAT(a.order_date, '%d-%m-%Y') AS DATE,
            CASE
                WHEN a.order_time IS NULL OR a.order_time = '0000-00-00 00:00:00' THEN '00:00:00'
                ELSE DATE_FORMAT(a.order_time, '%h:%i %p')
            END AS order_time,  
          DATE_FORMAT(a.delivery_date, '%d-%m-%Y')  AS deliverydate 
        FROM
            tbl_orders AS a
        INNER JOIN tbl_users AS b
        ON
            a.`user_id` = b.user_id
        WHERE
            a.flag = 1 AND  b.flag = 1 AND a.delivery_status = 6
       
          ORDER BY    STR_TO_DATE(a.order_date, '%d-%m-%Y') ASC;";
        $CancelOrders = $db->query($query)->getResultArray();





        echo json_encode($CancelOrders);
    }

    public function refundDetails()
    {
        $db = \Config\Database::connect();

        $query = "SELECT `delivery_status` FROM `tbl_orders` WHERE `flag` = 1";
        $res['del_status'] = $db->query($query)->getResultArray();

        $session = \Config\Services::session();

        if ($session->get('login_sts') == "") {
            return redirect()->to('admin');
        } else {

            $query = "SHOW COLUMNS FROM tbl_orders LIKE 'delivery_status'";
            $result = $db->query($query)->getRow();


            if ($result) {
                // Extract ENUM values from the Type field
                preg_match("/^enum\((.*)\)$/", $result->Type, $matches);
                if (!empty($matches[1])) {
                    $enumValues = explode(",", str_replace("'", "", $matches[1]));
                    // return $enumValues;
                }
            }

            $res['delivery_sts'] = $enumValues;
            return view('admin/refundDetails', $res);
        }

    }

    public function getrefundDetails()
    {
        $db = \Config\Database::connect();
        $query =
            "SELECT
            a.*,
            b.*,
            DATE_FORMAT(a.order_date, '%d-%m-%Y') AS DATE ,
          CASE
                WHEN a.order_time IS NULL OR a.order_time = '0000-00-00 00:00:00' THEN '00:00:00'
                ELSE DATE_FORMAT(a.order_time, '%h:%i %p')
            END AS order_time, 
          DATE_FORMAT(a.delivery_date, '%d-%m-%Y')  AS delivery_date 
        FROM
            tbl_orders AS a
        INNER JOIN tbl_users AS b
        ON
            a.`user_id` = b.user_id
        WHERE
            a.flag = 1 AND  b.flag = 1  AND (a.delivery_status = 7  OR a.delivery_status = 8 OR a.delivery_status = 9)
        ORDER BY
            `order_date` ASC";
        $CancelOrders = $db->query($query)->getResultArray();


        echo json_encode($CancelOrders);
    }


    public function paymentPendingOrder()
    {
        $db = \Config\Database::connect();

        $query = "SELECT `delivery_status` FROM `tbl_orders` WHERE `flag` = 1";
        $res['pending_order'] = $db->query($query)->getResultArray();

        $session = \Config\Services::session();

        if ($session->get('login_sts') == "") {
            return redirect()->to('admin');
        } else {
            $query = "SHOW COLUMNS FROM tbl_orders LIKE 'delivery_status'";
            $result = $db->query($query)->getRow();

            if ($result) {
                // Extract ENUM values from the Type field
                preg_match("/^enum\((.*)\)$/", $result->Type, $matches);
                if (!empty($matches[1])) {
                    $enumValues = explode(",", str_replace("'", "", $matches[1]));
                    // return $enumValues;
                }
            }

            $res['delivery_sts'] = $enumValues;



            return view('admin/orderPending', $res);
        }
    }

    public function getOrderPending()
    {
        $db = \Config\Database::connect();
        $query = "
    SELECT a.*, 
           b.*, 
           c.rzporder_id, 
           DATE_FORMAT(a.order_date, '%d-%m-%Y') AS date, 
           DATE_FORMAT(a.order_time, '%H:%i:%s') AS order_time , 
           DATE_FORMAT(a.delivery_date, '%d-%m-%Y') AS delivery_date
    FROM tbl_orders AS a
    INNER JOIN tbl_users AS b ON a.user_id = b.user_id
    LEFT JOIN payment_orderpending_log AS c ON c.order_id = a.order_id
    WHERE a.flag = 1 
      AND a.delivery_status = 1 
      AND b.flag = 1
      AND c.rzporder_id <> '' AND a.payment_status = 'PENDING'
    ORDER BY a.log ASC";
        $orderDetail = $db->query($query)->getResultArray();

        echo json_encode($orderDetail);
    }

    public function deactivateMenu()
    {
        $db = \Config\Database::connect();

        $id = $this->request->getPost('id');
        $column_name = $this->request->getPost('column_name');
        $tbl_name = $this->request->getPost('tbl_name');
        $active_status = $this->request->getPost('active_status');

        $updateQuery = "UPDATE `$tbl_name` SET `is_active` = ? WHERE `$column_name` = ?";
        $db->query($updateQuery, [$active_status, $id]);

        $affectedRows = $db->affectedRows();
        if ($affectedRows === 1) {
            $result['code'] = 200;
            $result['msg'] = 'Status updated Successfully';
            $result['status'] = 'success';
            echo json_encode($result);
        } else {
            $result['code'] = 400;
            $result['msg'] = 'Something Wrong';
            $result['status'] = 'failure';
            echo json_encode($result);
        }
    }


    public function deactivateSubMenu()
    {
        $db = \Config\Database::connect();

        $menu_id = $this->request->getPost('menu_id');
        $sub_menu_id = $this->request->getPost('sub_menu_id');
        $sub_menu_col = $this->request->getPost('sub_menu_col');
        $menu_col = $this->request->getPost('menu_col');
        $tbl_name = $this->request->getPost('tbl_name');
        $active_status = $this->request->getPost('active_status');


        $updateQuery = "UPDATE `$tbl_name` SET `is_active` = ? WHERE $menu_col  = ? AND $sub_menu_col = ? ";
        $db->query($updateQuery, [$active_status, $menu_id, $sub_menu_id]);

        $affectedRows = $db->affectedRows();
        if ($affectedRows === 1) {
            $result['code'] = 200;
            $result['msg'] = 'Status updated Successfully';
            $result['status'] = 'success';
            echo json_encode($result);
        } else {
            $result['code'] = 400;
            $result['msg'] = 'Something Wrong';
            $result['status'] = 'failure';
            echo json_encode($result);
        }
    }
}