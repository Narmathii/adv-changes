<?php

namespace App\Controllers\admin;

use App\Models\admin\LuggageSubmenuModel;

class LsubController extends BaseController
{
    public function LuggagesubMenu()
    {
        $db = \Config\Database::connect();
        $res['menu'] = $db->query('SELECT `lug_menu_id`,`lug_menu` FROM `tbl_luggage_menu` WHERE `flag`= 1 ORDER BY lug_menu ASC')->getResultArray();
        $session = \Config\Services::session();

        if ($session->get('login_sts') == "") {
            return redirect()->to('admin');
        } else {
            return view('admin/LuggageSubmenu', $res);
        }


    }

    public function insertsubMenu()
    {
        $db = \Config\Database::connect();
        $modal = new LuggageSubmenuModel;

        $MenuId = $this->request->getPost('lug_menu_id');
        $SubMenu = $this->request->getPost('lug_submenu');

        $data = [
            'lug_menu_id' => $MenuId,
            'lug_submenu' => $SubMenu
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

    public function getlugsubMenu()
    {
        $db = \Config\Database::connect();

        $query = 'SELECT a.lug_menu_id , a.lug_menu , b.* FROM
        tbl_luggage_menu AS a INNER JOIN tbl_luggage_submenu AS b 
        ON a.lug_menu_id = b.lug_menu_id AND b.`flag` = 1 ORDER BY  lug_menu ASC;';
        $res = $db->query($query)->getResultArray();

        echo json_encode($res);
    }

    public function updatesubMenu()
    {
        $SubmenuId = $this->request->getPost('lug_submenu_id');
        $menuId = $this->request->getPost('lug_menu_id');
        $Submenu = $this->request->getPost('lug_submenu');

        $db = \Config\Database::connect();
        $modal = new LuggageSubmenuModel;


        // getOld accessID ProductList
        $query1 = "SELECT `lug_submenu_id` ,`lug_menu_id`  FROM `tbl_luggage_submenu` WHERE `lug_submenu_id`  = ? AND flag = 1";
        $getSubmenu = $db->query($query1, [$SubmenuId])->getResultArray();

        $OldID = $getSubmenu[0]['lug_menu_id'];
        $OldSubID = $getSubmenu[0]['lug_submenu_id'];

        $query2 = "SELECT `prod_id` FROM `tbl_luggagee_products` WHERE `flag` = 1  AND `lug_menu_id` = ? AND lug_submenu_id = ?";
        $getProducts = $db->query($query2, [$OldID, $OldSubID])->getResultArray();

        $data = [
            'lug_menu_id' => $menuId,
            'lug_submenu' => $Submenu,
        ];
        $modal->update($SubmenuId, $data);

        $affectedRows = $db->affectedRows();

        if ($affectedRows == 1) {
            for ($i = 0; $i < count($getProducts); $i++) {
                $ProdID = $getProducts[$i]['prod_id'];

                $updateqry = "UPDATE tbl_luggagee_products SET lug_menu_id = ?  WHERE lug_submenu_id = ? AND lug_menu_id = ?";
                $updateProducts = $db->query($updateqry, [$menuId, $OldSubID, $OldID]);
            }
        }


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


    public function delsubMenu()
    {
        $db = \Config\Database::connect();

        $SubmenuId = $this->request->getPost('lug_submenu_id');

        $query = 'UPDATE`tbl_luggage_submenu` SET `flag` = 0 WHERE`lug_submenu_id` = ?';
        $res = $db->query($query, [$SubmenuId]);

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