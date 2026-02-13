<?php

namespace App\Controllers\admin;

use App\Models\admin\SubAccessModel;

class SubAccessController extends BaseController
{
    public function subAccessories()
    {
        $db = \Config\Database::connect();

        $query = 'SELECT `access_id`,`access_title` FROM `tbl_access_master` WHERE `flag` =1 ORDER BY `access_title` ASC';
        $res['access_data'] = $db->query($query)->getResultArray();

        $session = \Config\Services::session();

        if ($session->get('login_sts') == "") {
            return redirect()->to('admin');
        } else {
            return view('admin/subAccessories', $res);
        }

    }

    public function insertSubAccessories()
    {
        $db = \Config\Database::connect();
        $modal = new SubAccessModel;

        $saccess_id = $this->request->getPost('access_id');
        $subAccessName = $this->request->getPost('sub_access_name');

        $data = [
            'access_id' => $saccess_id,
            'sub_access_name' => $subAccessName
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


    public function getSubAccessories()
    {
        $db = \Config\Database::connect();

        $query = 'SELECT a.access_id ,a.access_title , b.* FROM tbl_access_master AS a INNER JOIN tbl_subaccess_master AS b 
        ON a.access_id = b.access_id WHERE b.`flag` =1  AND a.flag = 1 ORDER BY `access_title`  ASC;';

        $res = $db->query($query)->getResultArray();


        echo json_encode($res);

    }

    public function updateSubAccessories()
    {
        $db = \Config\Database::connect();
        $modal = new SubAccessModel;

        $data = $this->request->getPost();


        $SubAccessId = $this->request->getPost('sub_access_id');
        $accId = $this->request->getPost('access_id');
        $SubAccName = $this->request->getPost('sub_access_name');

        // getOld accessID ProductList
        $query1 = "SELECT `access_id` ,`sub_access_id`  FROM `tbl_subaccess_master` WHERE `sub_access_id`  = ? AND flag = 1";
        $getSubmenu = $db->query($query1, [$SubAccessId])->getResultArray();

        $OldAccID = $getSubmenu[0]['access_id'];
        $OldSubAccID = $getSubmenu[0]['sub_access_id'];

        $query2 = "SELECT `prod_id` FROM `tbl_accessories_list` WHERE `flag` = 1  AND `sub_access_id` = ? AND access_id = ?";
        $getProducts = $db->query($query2, [$OldSubAccID, $OldAccID])->getResultArray();

        $data = [
            'access_id' => $accId,
            'sub_access_name' => $SubAccName
        ];


        $modal->update($SubAccessId, $data);

        $affectedRows = $db->affectedRows();

        if ($affectedRows == 1) {
            for ($i = 0; $i < count($getProducts); $i++) {
                $ProdID = $getProducts[$i]['prod_id'];

                $updateqry = "UPDATE tbl_accessories_list SET access_id = ?  WHERE sub_access_id = ? AND access_id = ?";
                $updateProducts = $db->query($updateqry, [$accId, $OldSubAccID, $OldAccID]);
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

    public function deleteSubAccessories()
    {
        $db = \Config\Database::connect();

        $SubAccessId = $this->request->getPost('sub_access_id');

        $query = 'UPDATE  `tbl_subaccess_master` SET `flag` = 0 WHERE `sub_access_id` = ?;';
        $update = $db->query($query, [$SubAccessId]);

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
