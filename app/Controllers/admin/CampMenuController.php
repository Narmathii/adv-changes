<?php

namespace App\Controllers\admin;

use App\Models\admin\CampMenuModel;

class CampMenuController extends BaseController
{

    public function camping()
    {

        $session = \Config\Services::session();

        if ($session->get('login_sts') == "") {
            return redirect()->to('admin');
        } else {
            return view('admin/camping');
        }

    }

    public function insertCampMenu()
    {

        $db = \Config\Database::connect();
        $modal = new CampMenuModel;
        $Menu = $this->request->getPost('camp_menu');

        $data = [
            'camp_menu' => $Menu
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

    public function getCampMenu()
    {
        $db = \Config\Database::connect();

        $query = 'SELECT * FROM `tbl_camping_menu` WHERE `flag`= 1 ORDER BY `camp_menu` ASC ';
        $res = $db->query($query)->getResultArray();
        echo json_encode($res);
    }

    public function updateCampMenu()
    {


        $rmenuId = $this->request->getPost("camp_menu_id");

        $Menu = $this->request->getPost("camp_menu");
        $db = \Config\Database::connect();
        $modal = new CampMenuModel;

        $data = [
            'camp_menu' => $Menu,
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

    public function deleteCampMenu()
    {
        $db = \Config\Database::connect();

        $menuId = $this->request->getPost('camp_menu_id');

        $query = 'UPDATE`tbl_camping_menu` SET `flag` = 0 WHERE`camp_menu_id` = ?';
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