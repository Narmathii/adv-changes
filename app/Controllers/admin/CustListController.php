<?php
namespace App\Controllers\admin;

class CustListController extends BaseController
{

    public function custList()
    {
        return view("admin/custList");
    }

    public function getcustList()
    {
        $db = \Config\Database::connect();
        $query = "SELECT a.* , b.*,c.state_title, d.dist_name FROM `tbl_users` AS a 
        INNER JOIN tbl_user_address AS b 
        ON a.`user_id` = b.user_id 
        INNER JOIN tbl_state AS  c ON b.state_id = c.state_id 
        INNER JOIN tbl_district AS d ON b.dist_id = d.dist_id 
        WHERE a.flag = 1 AND b.flag = 1";

        $getRes = $db->query($query)->getResultArray();
        echo json_encode($getRes);
    }

    public function deletecustList()
    {
        $db = \Config\Database::connect();
        $userID = $this->request->getPost('user_id');
        $query = "UPDATE tbl_users SET flag = 0 WHERE user_id =? ";
        $Dlt = $db->query($query, $userID);
        if ($Dlt) {

            $res['code'] = 200;
            $res['msg'] = "Deleted Successfully";
            echo json_encode($res);

        } else {
            $res['code'] = 400;
            $res['msg'] = "Something wrong";
            echo json_encode($res);
        }

    }

}