<?php

namespace App\Controllers\admin;

use App\Models\admin\SubAccessModel;

class PaymentListController extends BaseController
{
    public function paymentList()
    {
        $db = \Config\Database::connect();
        $session = \Config\Services::session();

        if ($session->get('login_sts') == "") {
            return redirect()->to('admin');
        } else {
            return view('admin/paymentList');
        }

    }

    public function insertSubAccessories()
    {
        $db = \Config\Database::connect();
        $modal = new SubAccessModel;

        $saccess_id = $this->request->getPost('access_id');
        $subAccessName = $this->request->getPost('sub_access_name');

        $data = [
            'access_id' => $saccess_id,
            'sub_access_name' => $subAccessName
        ];

        $modal->insert($data);
        $affectedRows = $db->affectedRows();
        if ($affectedRows === 1) {
            $result['code'] = 200;
            $result['msg'] = 'Data Inserted Successfully';
            $result['status'] = 'success';
            echo json_encode($result);
        } else {
            $result['code'] = 400;
            $result['status'] = 'Failed';
            $result['msg'] = 'Something wrong';
            echo json_encode($result);
        }

    }


    public function getPaymentList()
    {
        $db = \Config\Database::connect();

        $query = "SELECT
    a.order_id,
    a.`razerpay_payment_id`,
    a.razerpay_order_id,
    a.order_no,
    a.payment_method,
    a.sub_total,
    DATE_FORMAT(a.updated_at, '%h:%i %p') AS payment_time,
    b.username
    FROM
        tbl_orders AS a
    INNER JOIN tbl_users AS b
    ON
        a.user_id = b.user_id
    WHERE
    a.flag = 1 AND b.flag = 1 AND a.payment_status = 2";

        $res = $db->query($query)->getResultArray();

        echo json_encode($res);

    }

    public function updateSubAccessories()
    {
        $db = \Config\Database::connect();
        $modal = new SubAccessModel;


        $SubAccessId = $this->request->getPost('sub_access_id');
        $accId = $this->request->getPost('access_id');
        $SubAccName = $this->request->getPost('sub_access_name');


        $data = [
            'access_id' => $accId,
            'sub_access_name' => $SubAccName
        ];


        $modal->update($SubAccessId, $data);
        $affectedRows = $db->affectedRows();
        if ($affectedRows === 1) {
            $result['code'] = 200;
            $result['msg'] = 'Data updates Successfully';
            $result['status'] = 'success';
            echo json_encode($result);
        } else {
            $result['code'] = 400;
            $result['msg'] = 'Something Wrong';
            $result['status'] = 'failure';
            echo json_encode($result);
        }

    }

    public function deletePaymentList()
    {
        $db = \Config\Database::connect();

        $orderID = $this->request->getPost('order_id');

        $query = 'UPDATE  `tbl_orders` SET `flag` = 0 WHERE `order_id` = ?;';
        $update = $db->query($query, [$orderID]);

        $affected_rows = $db->affectedRows();

        if ($affected_rows && $update) {
            $result['code'] = 200;
            $result['status'] = 'success';
            $result['message'] = 'Deleted Successfully';
            echo json_encode($result);
        } else {
            $result['code'] = 400;
            $result['status'] = 'Failure';
            $result['message'] = 'Something wrong';
            echo json_encode($result);
        }
    }

    public function filterPaymentList()
    {
        $db = \Config\Database::connect();
        $FilterDate = $this->request->getPost('filter_date');
        $query = "SELECT
        a.order_id,
        a.`razerpay_payment_id`,
        a.razerpay_order_id,
        a.order_no,
        a.payment_method,
        a.sub_total,
        DATE_FORMAT(a.updated_at, '%h:%i %p') AS payment_time,
        b.username
    FROM
        tbl_orders AS a
    INNER JOIN tbl_users AS b
    ON
        a.user_id = b.user_id
    WHERE
        a.flag = 1 AND b.flag = 1 AND a.payment_status = 2 AND DATE(a.updated_at) = '$FilterDate'";

        $res = $db->query($query)->getResultArray();
        echo json_encode($res);

    }
}
