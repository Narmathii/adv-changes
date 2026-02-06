<?php
namespace App\Controllers\admin;

use App\Models\admin\CourierModel;
use App\Models\admin\CourierChargeModel;

class CourierController extends BaseController
{
    public function courierPartner()
    {
        $session = \Config\Services::session();

        if ($session->get('login_sts') == "") {
            return redirect()->to('admin');
        } else {
            return view("admin/courierPartner");
        }

    }
    public function insertCourier()
    {
        $AddModel = new CourierModel;
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

    public function getCourier()
    {
        $db = \Config\Database::connect();
        $getData = $db->query("SELECT * FROM `tbl_couriers` WHERE `flag` =1")->getResultArray();
        echo json_encode($getData);
    }

    public function updateCourier()
    {
        $cID = $this->request->getPost('courier_id');
        $courierName = $this->request->getPost("courier_name");
        $courierURL = $this->request->getPost("c_url");

        $db = \Config\Database::connect();
        $query = "UPDATE tbl_couriers SET `courier_name` =? , `c_url` = ? WHERE courier_id = ? AND `flag` =1 ";
        $updateData = $db->query($query, [$courierName, $courierURL, $cID]);

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


    public function deleteCourier()
    {
        $cID = $this->request->getPost('courier_id');

        $db = \Config\Database::connect();

        $query = "UPDATE tbl_couriers SET `flag` = 0 WHERE courier_id = ?";
        $deleteData = $db->query($query, [$cID]);

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

    // *************************** Courier Charges *************************************************************************
    public function courierCharges()
    {
        $db = \Config\Database::connect();
        $res['district'] = $db->query("SELECT * FROM `tbl_district` WHERE `flag` = 1")->getResultArray();
        $res['couriers'] = $db->query("SELECT * FROM `tbl_couriers` WHERE `flag` = 1")->getResultArray();
        $res['state'] = $db->query("SELECT * FROM `tbl_state` WHERE `flag` = 1")->getResultArray();

        return view("admin/courierCharges", $res);
    }

    public function getDistfilr()
    {
        $db = \Config\Database::connect();
        $stateID = $this->request->getPost('state_id');

        $query = "SELECT `dist_id`,`dist_name` FROM `tbl_district` WHERE `flag` = 1 AND `state_id` = ?";
        $getResult = $db->query($query, [$stateID])->getResultArray();
        echo json_encode($getResult);
    }

    public function insertCharges()
    {
        $db = \Config\Database::connect();
        $stateID = $this->request->getPost();


        $stateID = $this->request->getPost('state_id');
        $distID = $this->request->getPost('dist_id');
        $courierID = $this->request->getPost('courier_id');
        $charges = $this->request->getPost('charges');
        $comments = $this->request->getPost('comments');
        $active_sts = $this->request->getPost('active_sts');

        $chargeModel = new CourierChargeModel;

        $data = [
            'courier_id' => $courierID,
            'state_id' => $stateID,
            'dist_id' => 0,
            'charges' => $charges,
            'comments' => $comments,
            'active_sts' => $active_sts
        ];

        $insertCharges = $chargeModel->insert($data);
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

    public function getCharges()
    {
        $db = \Config\Database::connect();
        $query = "SELECT DISTINCT
                a.state_title,a.state_id,
                CASE
                    WHEN c.dist_id = 0 THEN 'All District'
                    ELSE b.dist_name
                END AS dist_name,
                c.charges,c.active_sts,c.charge_id,c.courier_id,
                d.courier_name
            FROM
                tbl_state AS a
            INNER JOIN
                tbl_district AS b ON a.state_id = b.state_id
            INNER JOIN
                tbl_courier_charges AS c ON a.state_id = c.state_id
            INNER JOIN
                tbl_couriers AS d ON c.courier_id = d.courier_id
            WHERE
                (c.dist_id = 0 OR b.dist_id = c.dist_id)
                AND c.flag = 1";

        $getCharges = $db->query($query)->getResultArray();


        echo json_encode($getCharges);
    }

    public function updateCharges()
    {
        $chargeModel = new CourierChargeModel;

        $db = \Config\Database::connect();

        $courierID = $this->request->getPost('charge_id');
        $data = $this->request->getPost();

        

        $update = $chargeModel->update($courierID, $data);
        $affectedRows = $db->affectedRows();

        if ($update && $affectedRows > 0) {
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

    public function deleteCharges()
    {
        $db = \Config\Database::connect();

        $chargeID = $this->request->getPost("charge_id");


        $query = 'update`tbl_courier_charges` SET `flag` = 0 WHERE `charge_id` = ?';
        $res = $db->query($query, $chargeID);

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