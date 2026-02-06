<?php

namespace App\Controllers\admin;

use App\Models\admin\SubnavModel;

class SubNavController extends BaseController
{
    public function subNavbar()
    {
        $db = \Config\Database::connect();
        $query = 'SELECT `nav_id`,`nav_title` FROM `tbl_nav_master` WHERE `flag`=1';
        $res['navbar'] = $db->query($query)->getResultArray();

        $session = \Config\Services::session();

        if ($session->get('login_sts') == "") {
            return redirect()->to('admin');
        } else {
            return view('admin/subNavbar', $res);
        }


    }

    public function insertSubnavbar()
    {

        $db = \Config\Database::connect();
        $modal = new SubnavModel;

        $subNav = $this->request->getPost('sub_navbar');
        $navId = $this->request->getPost('nav_id');

        $data = [
            'nav_id' => $navId,
            'sub_navbar' => $subNav
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


    public function getSubnavbar()
    {

        $db = \Config\Database::connect();

        $query = 'SELECT a.nav_title , b.* FROM tbl_nav_master AS a INNER JOIN tbl_subnav_master AS b ON a.nav_id = b.nav_id WHERE b.flag =1';
        $res = $db->query($query)->getResultArray();
        echo json_encode($res);
    }
    public function deleteSubnavbar()
    {
        $db = \Config\Database::connect();

        $subnav_id = $this->request->getPost('subnav_id');

        $query = 'UPDATE tbl_subnav_master SET `flag` = 0 WHERE `subnav_id` = ?;';
        $dltData = $db->query($query, $subnav_id);

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

    public function updateSubnavbar()
    {
        $db = \Config\Database::connect();
        $modal = new SubnavModel;

        $SubnavId = $this->request->getPost('subnav_id');
        $navId = $this->request->getPost('nav_id');
        $subNavbar = $this->request->getPost('sub_navbar');

        $data = [
            'nav_id' => $navId,
            'sub_navbar' => $subNavbar,
        ];
        $modal->update($SubnavId, $data);

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
}