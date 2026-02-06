<?php

namespace App\Controllers\admin;

use App\Models\admin\RidingMenuModel;

class RidingMenuController extends BaseController
{

    public function ridingMenu()
    {

        $session = \Config\Services::session();

        if ($session->get('login_sts') == "") {
            return redirect()->to('admin');
        } else {
            return view('admin/ridingMenu');
        }

    }

    public function insertMenu()
    {
        $db = \Config\Database::connect();
        $modal = new RidingMenuModel;

        $RidingMenu = $this->request->getPost('r_menu');

        $data = [
            'r_menu' => $RidingMenu
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

        $query = 'SELECT * FROM `tbl_riding_menu` WHERE `flag`= 1 ORDER BY r_menu ASC';
        $res = $db->query($query)->getResultArray();
        echo json_encode($res);
    }

    public function updateMenuList()
    {


        $rmenuId = $this->request->getPost('r_menu_id');

        $RidingMenu = $this->request->getPost('r_menu');


        $db = \Config\Database::connect();
        $modal = new RidingMenuModel;

        $data = [
            'r_menu' => $RidingMenu,
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

    public function deleteMenuList()
    {
        $db = \Config\Database::connect();

        $rmenuId = $this->request->getPost('r_menu_id');

        $query = 'UPDATE`tbl_riding_menu` SET `flag` = 0 WHERE`r_menu_id` = ?';
        $res = $db->query($query, [$rmenuId]);

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