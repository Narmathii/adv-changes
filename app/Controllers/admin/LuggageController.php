<?php

namespace App\Controllers\admin;

use App\Models\admin\LuggageMenuModel;

class LuggageController extends BaseController
{
    public function LuggageMenu()
    {

        $session = \Config\Services::session();

        if ($session->get('login_sts') == "") {
            return redirect()->to('admin');
        } else {
            return view('admin/LuggageMenu');
        }

    }

    public function insertLuggageMenu()
    {
        $db = \Config\Database::connect();
        $modal = new LuggageMenuModel;

        $lugMenu = $this->request->getPost('lug_menu');

        $data = [
            'lug_menu' => $lugMenu
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

    public function getLuggageMenu()
    {
        $db = \Config\Database::connect();

        $query = 'SELECT * FROM `tbl_luggage_menu` WHERE `flag`= 1 ORDER BY `lug_menu` ASC';
        $res = $db->query($query)->getResultArray();
        echo json_encode($res);
    }

    public function updateLuggageMenu()
    {

        $db = \Config\Database::connect();
        $modal = new LuggageMenuModel;

        $lugId = $this->request->getPost('lug_menu_id');
        $lugMenu = $this->request->getPost('lug_menu');

        $data = [
            'lug_menu' => $lugMenu,
        ];
        $modal->update($lugId, $data);

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


    public function deleteLuggageMenu()
    {

        $db = \Config\Database::connect();

        $rmenuId = $this->request->getPost('lug_menu_id');

        $query = 'UPDATE`tbl_luggage_menu` SET `flag` = 0 WHERE`lug_menu_id` = ?';
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