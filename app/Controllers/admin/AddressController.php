<?php
namespace App\Controllers\admin;

use App\Models\admin\StateModel;
use App\Models\admin\DistModel;

class AddressController extends BaseController
{
    public function stateList()
    {
        return view('admin/stateList');
    }

    public function insertState()
    {
        $AddModel = new StateModel;
        $db = \Config\Database::connect();

        $data = $this->request->getPost();
        $insertData = $AddModel->insert($data);
        $affectedRows = $db->affectedRows();
        if ($affectedRows === 1 && $insertData) {
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


    public function getState()
    {
        $db = \Config\Database::connect();
        $getData = $db->query("SELECT * FROM `tbl_state` WHERE `flag` =1")->getResultArray();
        echo json_encode($getData);
    }


    public function updateState()
    {
        $stateID = $this->request->getPost('state_id');
        $stateTitle = $this->request->getPost("state_title");
        $db = \Config\Database::connect();


        $query = "UPDATE tbl_state SET `state_title` =   ? WHERE `state_id` = ? AND `flag` =1 ";
        $updateData = $db->query($query, [$stateTitle, $stateID]);

        $affectedRow = $db->affectedRows();

        if ($updateData && $affectedRow == 1) {
            $res['code'] = 200;
            $res['msg'] = 'Data updates Successfully';
            $res['status'] = 'success';
            echo json_encode($res);
        } else {
            $res['code'] = 400;
            $res['msg'] = 'Data updates Failed';
            $res['status'] = 'failure';
            echo json_encode($res);
        }

    }


    public function deleteState()
    {
        $stateID = $this->request->getPost('state_id');

        $db = \Config\Database::connect();

        $query = "UPDATE tbl_state SET `flag` = 0 WHERE state_id = ?";
        $deleteData = $db->query($query, [$stateID]);

        $affectedRow = $db->affectedRows();
        if ($deleteData && $affectedRow == 1) {
            $res['code'] = 200;
            $res['msg'] = 'Data Deleted Successfully';
            $res['status'] = 'success';
            echo json_encode($res);
        } else {
            $res['code'] = 400;
            $res['msg'] = 'Something went Wrong !';
            $res['status'] = 'failure';
            echo json_encode($res);
        }
    }

    // #***************************************** District ********************************************

    public function district()
    {
        $db = \Config\Database::connect();
        $res['state'] = $db->query("SELECT `state_id`, `state_title` FROM `tbl_state` WHERE `flag` = 1")->getResultArray();
        return view("admin/district", $res);
    }


    public function insertDistrict()
    {

        $data = $this->request->getPost();
        $db = \Config\Database::connect();

        $DistMod = new DistModel;

        $insertData = $DistMod->insert($data);
        $affectedRows = $db->affectedRows();
        if ($affectedRows === 1 && $insertData) {
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


    public function getDistrict()
    {
        $db = \Config\Database::connect();

        $getDta = $db->query(
            "SELECT a.`dist_id`,a.`state_id`,a.`dist_name`,b.state_title 
             FROM tbl_district AS a INNER JOIN tbl_state AS b 
             ON a.state_id = b.state_id WHERE a.flag = 1"
        )->getResultArray();

        echo json_encode($getDta);
    }

    public function updateDistrict()
    {
        $db = \Config\Database::connect();
        $State_id = $this->request->getPost('state_id');
        $dist = $this->request->getPost('dist_name');
        $distID = $this->request->getPost('dist_id');


        $query = "UPDATE  tbl_district SET  `state_id` = ? , `dist_name` =? 
                   WHERE dist_id = ? AND flag=1";
        $updateData = $db->query($query, [$State_id, $dist, $distID]);
        $affectedRow = $db->affectedRows();

        if ($updateData && $affectedRow == 1) {
            $res['code'] = 200;
            $res['msg'] = 'Data updates Successfully';
            $res['status'] = 'success';
            echo json_encode($res);
        } else {
            $res['code'] = 400;
            $res['msg'] = 'Data updates Failed';
            $res['status'] = 'failure';
            echo json_encode($res);
        }

    }

    public function deleteDistrict()
    {
        $distID = $this->request->getPost('dist_id');

        $db = \Config\Database::connect();

        $query = "UPDATE tbl_district SET `flag` = 0 WHERE dist_id = ?";
        $deleteData = $db->query($query, [$distID]);

        $affectedRow = $db->affectedRows();
        if ($deleteData && $affectedRow == 1) {
            $res['code'] = 200;
            $res['msg'] = 'Data Deleted Successfully';
            $res['status'] = 'success';
            echo json_encode($res);
        } else {
            $res['code'] = 400;
            $res['msg'] = 'Something went Wrong !';
            $res['status'] = 'failure';
            echo json_encode($res);
        }
    }





}