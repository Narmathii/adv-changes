<?php

namespace App\Controllers\admin;

use App\Models\admin\HelmetMenuModel;

class HelmetController extends BaseController
{

    public function helmetMenu()
    {

        $session = \Config\Services::session();

        if ($session->get('login_sts') == "") {
            return redirect()->to('admin');
        } else {
            return view('admin/helmetMenu');
        }

    }

    public function insertMenu()
    {

        $db = \Config\Database::connect();
        $modal = new HelmetMenuModel;
        $Menu = $this->request->getPost('h_menu');

        $data = [
            'h_menu' => $Menu
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

    public function getMenu()
    {
        $db = \Config\Database::connect();

        $query = 'SELECT * FROM `tbl_helmet_menu` WHERE `flag`= 1 ORDER BY `h_menu` ASC';
        $res = $db->query($query)->getResultArray();
        echo json_encode($res);
    }

    public function updateMenu()
    {


        $rmenuId = $this->request->getPost('h_menu_id');

        $Menu = $this->request->getPost('h_menu');


        $db = \Config\Database::connect();
        $modal = new HelmetMenuModel;

        $data = [
            'h_menu' => $Menu,
        ];
        $modal->update($rmenuId, $data);

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

    public function deleteMenu()
    {
        $db = \Config\Database::connect();

        $menuId = $this->request->getPost('h_menu_id');

        $query = 'UPDATE`tbl_helmet_menu` SET `flag` = 0 WHERE`h_menu_id` = ?';
        $res = $db->query($query, [$menuId]);

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