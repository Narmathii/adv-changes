<?php
namespace App\Controllers;

use App\Models\AddressModel;

class AddressController extends BaseController
{


    // *****************************************Insert Address***********************************************************

    public function getDist()
    {

        // $csrf = $this->request->getHeader('X-CSRF-TOKEN')->getValue();

        $db = \Config\Database::connect();
        $stateID = $this->request->getPost('state_id');

        $getData["response"] = $db->query("SELECT a.`state_title`, b.`dist_id`,b.`dist_name` FROM 
        tbl_state AS a INNER JOIN tbl_district AS b 
        ON a.state_id = b.state_id WHERE  a.`flag` = 1 AND b.state_id = $stateID;")->getResultArray();
        $getData['code'] = 200;
        // $getData['csrf'] = csrf_hash();

        echo json_encode($getData);
    }
    public function insertAddress()
    {
        $userID = session()->get('user_id');
        $AddressModel = new AddressModel;
        $db = \Config\Database::connect();

        $stateID = $this->request->getPost('state_id');
        $data = $this->request->getPost();

        $distID = $this->request->getPost('dist_id');
        $landMark = $this->request->getPost('landmark');
        $city = $this->request->getPost('city');
        $address = $this->request->getPost('address');
        $pincode = $this->request->getPost('pincode');
        $defaultAddr = $this->request->getPost('default_addr');

        $checkDefault = $defaultAddr == "true" ? 1 : 0;


        $query = "SELECT * FROM `tbl_user_address` WHERE `flag` = 1 AND `user_id` = ? AND `default_addr` = 1";
        $getAddr = $db->query($query, [$userID])->getResult();



        if ($defaultAddr == 'true') {
            if (count($getAddr) > 0) {
                $oldID = $getAddr[0]->add_id;

                $query = "UPDATE tbl_user_address SET default_addr = 0 WHERE add_id = ? AND user_id = ?";
                $updateAddr = $db->query($query, [$oldID, $userID]);
            }
        }

        $data = [
            "user_id" => $userID,
            "state_id" => $stateID,
            "dist_id" => $distID,
            "landmark" => $landMark,
            "city" => $city,
            "address" => $address,
            "pincode" => $pincode,
            "default_addr" => $checkDefault
        ];

        $insertData = $AddressModel->insert($data);
        $affectedRows = $db->affectedRows();
        if ($affectedRows === 1 && $insertData) {
            $result['code'] = 200;
            $result['msg'] = 'Address added Successfully';
            $result['status'] = 'success';
            $result['csrf'] = csrf_hash();

            echo json_encode($result);
        } else {
            $result['code'] = 400;
            $result['status'] = 'Failed';
            $result['msg'] = 'Something wrong';
            $result['csrf'] = csrf_hash();

            echo json_encode($result);
        }
    }



    public function getAddress()
    {
        $db = \Config\Database::connect();
        $userID = session()->get("user_id");



        $query = "SELECT a.*, b.state_title, c.dist_name 
        FROM tbl_user_address AS a 
        INNER JOIN tbl_state AS b ON a.state_id = b.state_id
        INNER JOIN tbl_district AS c ON a.dist_id = c.dist_id
        WHERE a.user_id = $userID AND a.flag = 1;";
        $getAdd = $db->query($query, [$userID])->getResultArray();
        echo json_encode($getAdd);
    }

    public function updateAddress()
    {

        $AddressModel = new AddressModel;
        $db = \Config\Database::connect();
        $data = $this->request->getPost();


        $addID = $this->request->getPost("add_id");
        $userID = session()->get('user_id');

        $state = $this->request->getPost('state_id');
        $dist = $this->request->getPost('dist_id');
        $landmark = $this->request->getPost('landmark');
        $city = $this->request->getPost('city');
        $address = $this->request->getPost('address');
        $pincode = $this->request->getPost('pincode');
        $defaultAddr = $this->request->getPost('default_addr');
        $checkDefault = $defaultAddr == "true" ? 1 : 0;


        if ($checkDefault == 1) {
            $query = "SELECT * FROM `tbl_user_address` WHERE `flag` = 1 AND `user_id` = ? AND `default_addr` = 1";
            $getAddr = $db->query($query, [$userID])->getResult();
            if (count($getAddr) > 0) {
                $oldID = $getAddr[0]->add_id;
                $query = "UPDATE tbl_user_address SET default_addr = 0 WHERE add_id = ? AND user_id = ?";
                $updateAddr = $db->query($query, [$oldID, $userID]);
            }
        }

        $query = "UPDATE tbl_user_address 
                  SET state_id = ?, dist_id = ?, landmark = ?, city = ?, address = ?, pincode = ?, default_addr = ? 
                  WHERE user_id = ? AND add_id = ?";
        $updateData = $db->query($query, [$state, $dist, $landmark, $city, $address, $pincode, $checkDefault, $userID, $addID]);

        $affectedRows = $db->affectedRows();
        if ($affectedRows > 0) {
            $result['code'] = 200;
            $result['msg'] = 'Data updated successfully';
            $result['status'] = 'success';
            $result['csrf'] = csrf_hash();
        } else {
            $result['code'] = 400;
            $result['msg'] = 'No data updated or something went wrong';
            $result['status'] = 'failure';
            $result['csrf'] = csrf_hash();
        }

        echo json_encode($result);
    }


    public function deleteAddress()
    {
        $addID = $this->request->getPost('add_id');

        $db = \Config\Database::connect();

        $query = "UPDATE tbl_user_address SET `flag` = 0 WHERE add_id =? ";
        $dltData = $db->query($query, [$addID]);
        $affected_rows = $db->affectedRows();

        if ($affected_rows && $dltData) {
            $result['code'] = 200;
            $result['status'] = 'success';
            $result['message'] = 'Deleted Successfully';
            $result['csrf'] = csrf_hash();
            echo json_encode($result);
        } else {
            $result['code'] = 400;
            $result['status'] = 'Failure';
            $result['message'] = 'Something wrong';
            $result['csrf'] = csrf_hash();
            echo json_encode($result);
        }
    }

}