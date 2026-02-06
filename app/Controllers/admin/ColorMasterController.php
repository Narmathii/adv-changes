<?php

namespace App\Controllers\admin;

use App\Models\admin\ColorMasterModel;

class ColorMasterController extends BaseController
{
    public function colorMaster()
    {
        $db = \Config\Database::connect();

        $session = \Config\Services::session();

        if ($session->get('login_sts') == "") {
            return redirect()->to('admin');
        } else {
            return view('admin/colorMaster');
        }


    }

    public function insertColorMaster()
    {
        $db = \Config\Database::connect();
        $modal = new ColorMasterModel;

        $ColorName = strtoupper($this->request->getPost('color_name'));
        $HexCode = $this->request->getPost('hex_code');

        $data = [
            'color_name' => $ColorName,
            'hex_code' => $HexCode
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


    public function getColorMaster()
    {
        $db = \Config\Database::connect();

        $query = 'SELECT * FROM `tbl_color` WHERE `flag` = 1';
        $res = $db->query($query)->getResultArray();

        echo json_encode($res);

    }

    public function updateColorMaster()
    {
        $db = \Config\Database::connect();
        $modal = new ColorMasterModel;


        $ColorID = $this->request->getPost('color_id');
        $ColorName = strtoupper($this->request->getPost('color_name'));
        $HexCode = $this->request->getPost('hex_code');


        $data = [
            'color_name' => $ColorName,
            'hex_code' => $HexCode
        ];

        $modal->update($ColorID, $data);
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

    public function deleteColorMaster()
    {
        $db = \Config\Database::connect();

        $colorId = $this->request->getPost('color_id');

        $query = 'UPDATE  `tbl_color` SET `flag` = 0 WHERE `color_id` = ?;';
        $update = $db->query($query, [$colorId]);

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
}
