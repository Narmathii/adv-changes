<?php

namespace App\Controllers\admin;


class AdventureController extends BaseController
{



    public function index()
    {
        $db = \Config\Database::connect();

        $session = $this->session = \Config\Services::session();

        $res['pending_order'] = $db->query("SELECT COUNT(`order_id`) AS pending_order FROM `tbl_orders` WHERE  flag= 1 AND `delivery_status` = 3
        GROUP BY delivery_status")->getResultArray();
        $res['new_order'] = $db->query("SELECT COUNT(`order_id`) AS new_order FROM `tbl_orders` WHERE  flag= 1 AND `delivery_status` = 2
        GROUP BY delivery_status")->getResultArray();
        $res['shipping_status'] = $db->query("SELECT COUNT(`order_id`) AS shipping_status FROM `tbl_orders` WHERE  flag= 1 AND `delivery_status` = 4
        GROUP BY delivery_status")->getResultArray();
        $res['delivery_status'] = $db->query("SELECT COUNT(`order_id`) AS delivery_status FROM `tbl_orders` WHERE  flag= 1 AND `delivery_status` = 5
        GROUP BY delivery_status")->getResultArray();
        $res['order_pending_status'] = $db->query("
    SELECT 
        COUNT(a.order_id) AS order_pending,
        MAX(b.rzporder_id) AS rzporder_id
    FROM tbl_orders AS a
    INNER JOIN payment_orderpending_log AS b ON a.order_id = b.order_id
    WHERE a.flag = 1 
      AND a.delivery_status = 1 
      AND b.rzporder_id <> ''
    GROUP BY a.delivery_status
")->getResultArray();




        $res['refund_status'] = $db->query("
        SELECT COUNT(`order_id`) AS delivery_status 
            FROM `tbl_orders` 
            WHERE flag = 1 
            AND (`delivery_status` = 7 OR `delivery_status` = 8 OR `delivery_status` = 9)
            ")->getResultArray();

        $res['cancelled_status'] = $db->query("
        SELECT COUNT(`order_id`) AS delivery_status 
        FROM `tbl_orders` 
        WHERE flag = 1 
        AND `delivery_status` = 6")->getResultArray();




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





        $session = \Config\Services::session();

        if ($session->get('login_sts') == "") {
            return redirect()->to('admin');
        } else {
            return view('admin/dashboard', $res);
        }


    }

}