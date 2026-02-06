<?php

namespace App\Controllers\admin;

use App\Models\admin\AccessModel;

class AccessController extends BaseController
{

    public function Accessories()
    {


        $session = \Config\Services::session();

        if ($session->get('login_sts') == "") {
            return redirect()->to('admin');
        } else {
            return view('admin/Accessories');
        }


    }

    public function insertAccessories()
    {
        $db = \Config\Database::connect();
        $modal = new AccessModel;

        $AccessName = $this->request->getPost('access_title');

        $data = [
            'access_title' => $AccessName
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

    public function getAccessories()
    {

        $db = \Config\Database::connect();

        $query = 'SELECT * FROM `tbl_access_master` WHERE `flag` =1 ORDER BY `access_title` ASC';
        $res = $db->query($query)->getResultArray();
        echo json_encode($res);
    }

    public function updateAccessories()
    {

        $db = \Config\Database::connect();
        $modal = new AccessModel;

        $accId = $this->request->getPost('access_id');
        $accName = $this->request->getPost('access_title');

        $data = [
            'access_title' => $accName,
        ];
        $modal->update($accId, $data);

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

    public function deleteAccessories()
    {
        $db = \Config\Database::connect();

        $access_id = $this->request->getPost('access_id');

        $query = 'UPDATE`tbl_access_master` SET `flag` = 0 WHERE`access_id` = ?';
        $res = $db->query($query, [$access_id]);

        $affected_rows = $db->affectedRows();

        if ($affected_rows && $res) {
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
}