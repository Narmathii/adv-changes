<?php
namespace App\Controllers\admin;

use App\Models\admin\SubMenuModel;

class SubmenuController extends BaseController
{

    public function subMenu()
    {

        $db = \Config\Database::connect();
        $query = 'SELECT `subnav_id`,`sub_navbar`,nav_id  FROM `tbl_subnav_master` WHERE `flag`=1';
        $res['subNav'] = $db->query($query)->getResultArray();

        $session = \Config\Services::session();

        if ($session->get('login_sts') == "") {
            return redirect()->to('admin');
        } else {
            return view('admin/subMenu', $res);
        }


    }


    public function insertSubmenu()
    {

        $db = \Config\Database::connect();
        $modal = new SubMenuModel;

        $SubnavId = $this->request->getPost('subnav_id');
        $subMenu = $this->request->getPost('sub_menu');

        $data = [
            'subnav_id' => $SubnavId,
            'sub_menu' => $subMenu
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

    public function getSubmenu()
    {
        $db = \Config\Database::connect();

        $query = 'SELECT a.subnav_id , a.sub_navbar , b.* FROM tbl_subnav_master AS a
        INNER JOIN tbl_submenu_master AS b ON a.`subnav_id` = b.`subnav_id` 
        WHERE b.flag =1';

        $res = $db->query($query)->getResultArray();
        echo json_encode($res);

    }

    public function updateSubmenu()
    {
        $db = \Config\Database::connect();
        $modal = new SubMenuModel;

        $subMenuId = $this->request->getPost('sub_menu_id');
        $sunavId = $this->request->getPost('subnav_id');
        $subMenu = $this->request->getPost('sub_menu');

        $data = [
            'subnav_id' => $sunavId,
            'sub_menu' => $subMenu,
        ];
        $modal->update($subMenuId, $data);

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

    public function deleteSubmenu()
    {
        $db = \Config\Database::connect();

        $subMenuId = $this->request->getPost('sub_menu_id');

        $query = 'UPDATE tbl_submenu_master SET `flag` = 0 WHERE `sub_menu_id` = ?;';
        $dltData = $db->query($query, $subMenuId);
        $affected_rows = $db->affectedRows();
        if ($dltData && $affected_rows) {
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
        ;


    }


}