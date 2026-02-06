<?php

namespace App\Controllers\admin;


class NewOrderController extends BaseController
{

    public function newOrder()
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

            return view("admin/neworder", $res);
        }

    }

    public function getNewOrder()
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
            WHERE a.flag = 1 AND b.flag = 1 AND a.delivery_status =  2 AND a.order_status <> 'initiated'
            ORDER BY `order_date` ASC";
        $orderDetail = $db->query($query)->getResultArray();

        echo json_encode($orderDetail);
    }
}