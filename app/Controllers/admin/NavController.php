<?php


namespace App\Controllers\admin;

use App\Models\admin\NavModel;
use CodeIgniter\Debug\ExceptionHandler;

class NavController extends BaseController
{

    public function navbar()
    {
        $session = \Config\Services::session();

        if ($session->get('login_sts') == "") {
            return redirect()->to('admin');
        } else {
            return view('admin/Navbar');
        }

    }

    public function insertNavbar()
    {

        $db = \Config\Database::connect();
        $modal = new NavModel;

        $navTitle = $this->request->getPost('nav_title');


        $data = [
            'nav_title' => $navTitle
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


    public function getNavbar()
    {
        $db = \Config\Database::connect();
        $query = 'SELECT * FROM `tbl_nav_master` WHERE `flag`=1';
        $res = $db->query($query)->getResultArray();
        echo json_encode($res);
    }

    public function updateNavbar()
    {
        $db = \Config\Database::connect();
        $modal = new NavModel;

        $navId = $this->request->getPost('nav_id');
        $navTitle = $this->request->getPost('nav_title');

        $data = [
            'nav_title' => $navTitle,
        ];
        $modal->update($navId, $data);

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

    public function deleteNavbar()
    {
        $db = \Config\Database::connect();

        $navId = $this->request->getPost('nav_id');

        $query = 'UPDATE`tbl_nav_master` SET `flag` = 0 WHERE`nav_id` = ?';
        $res = $db->query($query, [$navId]);

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