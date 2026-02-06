<?php

namespace App\Controllers\admin;

use App\Models\admin\RsubMenuModal;

class RsubMenuController extends BaseController
{

    public function rSubMenu()
    {
        $db = \Config\Database::connect();
        $res['menu'] = $db->query('SELECT `r_menu_id`,`r_menu`  FROM `tbl_riding_menu` WHERE `flag` = 1 ORDER BY `r_menu` ASC')->getResultArray();

        $session = \Config\Services::session();

        if ($session->get('login_sts') == "") {
            return redirect()->to('admin');
        } else {
            return view('admin/ridingSubMenu', $res);
        }

    }

    public function insertSubMenu()
    {
        $db = \Config\Database::connect();
        $modal = new RsubMenuModal;

        $MenuId = $this->request->getPost('r_menu_id');
        $SubMenu = $this->request->getPost('r_sub_menu');


        $data = [
            'r_menu_id' => $MenuId,
            'r_sub_menu' => $SubMenu
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

    public function getSubMenu()
    {
        $db = \Config\Database::connect();
        $query = 'SELECT a.`r_menu_id`,a.`r_menu`, b.* 
        FROM `tbl_riding_menu` AS a 
        INNER JOIN `tbl_riding_submenu` AS b
        ON a.`r_menu_id` = b.`r_menu_id` WHERE b.`flag` =1
        ORDER BY r_menu ASC;';
        $res = $db->query($query)->getResultArray();
        echo json_encode($res);
    }

    public function updateSubMenu()
    {
        $SubmenuId = $this->request->getPost('r_sub_id');
        $menuId = $this->request->getPost('r_menu_id');
        $Submenu = $this->request->getPost('r_sub_menu');

        $db = \Config\Database::connect();
        $modal = new RsubMenuModal;


        // getOld accessID ProductList
        $query1 = "SELECT `r_sub_id` ,`r_menu_id`  FROM `tbl_riding_submenu` WHERE `r_sub_id`  = ? AND flag = 1";
        $getSubmenu = $db->query($query1, [$SubmenuId])->getResultArray();

        $OldAccID = $getSubmenu[0]['r_menu_id'];
        $OldSubAccID = $getSubmenu[0]['r_sub_id'];

        $query2 = "SELECT `prod_id` FROM `tbl_rproduct_list` WHERE `flag` = 1  AND `r_sub_id` = ? AND r_menu_id = ?";
        $getProducts = $db->query($query2, [$OldSubAccID, $OldAccID])->getResultArray();


        $data = [
            'r_menu_id' => $menuId,
            'r_sub_menu' => $Submenu,
        ];
        $modal->update($SubmenuId, $data);

        $affectedRows = $db->affectedRows();

        if ($affectedRows == 1) {
            for ($i = 0; $i < count($getProducts); $i++) {
                $ProdID = $getProducts[$i]['prod_id'];

                $updateqry = "UPDATE tbl_rproduct_list SET r_menu_id = ?  WHERE r_sub_id = ? AND r_menu_id = ?";
                $updateProducts = $db->query($updateqry, [$menuId, $OldSubAccID, $OldAccID]);
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


    public function deleteSubMenu()
    {
        $db = \Config\Database::connect();

        $SubmenuId = $this->request->getPost('r_sub_id');

        $query = 'UPDATE`tbl_riding_submenu` SET `flag` = 0 WHERE`r_sub_id` = ?';
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