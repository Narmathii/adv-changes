<?php
namespace App\Controllers;

use App\Models\LoginModel;
use App\Models\AddressModel;



class UserController extends BaseController
{


    private function headerlist()
    {
        $db = \Config\Database::connect();
        $res['brand_master'] = $db->query('SELECT * FROM `brand_master` WHERE  `flag` =1 ORDER BY brand_name ASC')->getResultArray();
        $res['brand'] = $db->query('SELECT `brand_id`,UPPER(`brand_name`) AS `brand_name` ,`brand_img` FROM `tbl_brand_master` WHERE  `flag` =1 ORDER BY brand_name ASC')->getResultArray();
        $res['modal'] = $db->query('SELECT `modal_id` ,`brand_id`, CONCAT(UPPER(SUBSTRING(modal_name, 1, 1)), LOWER(SUBSTRING(modal_name, 2))) AS `modal_name` FROM `tbl_modal_master` WHERE  `flag` = 1 ORDER BY modal_name ASC ')->getResultArray();

        $res['accessories'] = $db->query('SELECT `access_id`, UPPER(`access_title`) AS `access_title`  FROM `tbl_access_master` WHERE `flag` = 1  ORDER BY  `access_title` ASC;')->getResultArray();
        $res['sub_accessories'] = $db->query('SELECT `sub_access_id`,`access_id`, CONCAT(UPPER(SUBSTRING(`sub_access_name`, 1, 1)), LOWER(SUBSTRING(`sub_access_name`, 2))) AS `sub_access_name`  FROM `tbl_subaccess_master` WHERE `flag` = 1 ORDER BY sub_access_name ASC;')->getResultArray();

        $res['riding_menu'] = $db->query('SELECT `r_menu_id` , UPPER(`r_menu`) AS `r_menu`  FROM `tbl_riding_menu` WHERE `flag` =1 ORDER BY r_menu ASC;')->getResultArray();
        $res['riding_submenu'] = $db->query('SELECT `r_sub_id`,`r_menu_id`,CONCAT(UPPER(SUBSTRING(`r_sub_menu`, 1, 1)), LOWER(SUBSTRING(`r_sub_menu`, 2))) AS `r_sub_menu`  FROM `tbl_riding_submenu` WHERE flag =1 ORDER BY r_sub_menu ASC')->getResultArray();

        $res['lug_menu'] = $db->query('SELECT `lug_menu_id`,UPPER(`lug_menu`) AS `lug_menu`  FROM `tbl_luggage_menu` WHERE  `flag` = 1 ORDER BY lug_menu')->getResultArray();
        $res['lud_submenu'] = $db->query('SELECT `lug_submenu_id`,`lug_menu_id`,CONCAT(UPPER(SUBSTRING(`lug_submenu`, 1, 1)), LOWER(SUBSTRING(`lug_submenu`, 2))) AS `lug_submenu` FROM `tbl_luggage_submenu` WHERE  `flag` =1 ORDER BY lug_submenu ASC')->getResultArray();

        $res['h_menu'] = $db->query('SELECT `h_menu_id`,UPPER(`h_menu`) AS `h_menu` FROM `tbl_helmet_menu` WHERE `flag` = 1 ORDER BY h_menu ASC')->getResultArray();
        $res['h_submenu'] = $db->query('SELECT `h_submenu_id`,`h_menu_id`, CONCAT(UPPER(SUBSTRING(`h_submenu`, 1, 1)), LOWER(SUBSTRING(`h_submenu`, 2))) AS `h_submenu`,`hsubmenu_img`FROM `tbl_helmet_submenu` WHERE `flag` = 1 ORDER BY h_submenu ASC')->getResultArray();

        $res['h_submenu_list'] = $db->query('SELECT `h_submenu_id`,`h_menu_id`, CONCAT(UPPER(SUBSTRING(`h_submenu`, 1, 1)), LOWER(SUBSTRING(`h_submenu`, 2))) AS `h_submenu`,`hsubmenu_img`FROM `tbl_helmet_submenu` WHERE `flag` = 1 AND  `h_menu_id` = 2 ORDER BY h_submenu ASC')->getResultArray();

        $res['camp_menu'] = $db->query('SELECT `camp_menu_id` ,UPPER(`camp_menu`) AS `camp_menu` FROM `tbl_camping_menu` WHERE flag = 1 ORDER BY camp_menu ASC;')->getResultArray();
        $res['camp_submenu'] = $db->query('SELECT `c_submenu_id`,`camp_menuid`,  CONCAT(UPPER(SUBSTRING(`c_submenu`, 1, 1)), LOWER(SUBSTRING(`c_submenu`, 2))) AS `c_submenu`,`csubmenu_img` FROM `tbl_camping_submenu` WHERE flag = 1 ORDER BY `c_submenu` ASC')->getResultArray();
        return $res;
    }
    public function myprofile()
    {

        $db = \Config\Database::connect();

        $res = $this->headerlist();

        // to get cart count 
        $userID = session()->get('user_id');
        if ($userID) {
            $countQuery = "SELECT COUNT(`prod_id`)  AS cart_count FROM tbl_user_cart WHERE  user_id = $userID AND   `flag` = 1";
            $cartCount = $db->query($countQuery)->getRow();
            $res['cart_count'] = $cartCount->cart_count;
        } else if ($userID = "") {
            $tempcount = session()->get('temp_count');
            $res['cart_count'] = $tempcount;
        } else {
            $res['cart_count'] = 0;
        }

        // Get profile data 
        $res['profile'] = $db->query("SELECT * FROM `tbl_users` WHERE `flag` = 1 AND user_id = $userID")->getResultArray();

        // to get wishlist count 
        $res['wishlist_count'] = $this->getWishlistCount();

        return view('myprofile', $res);
    }

    public function getWishlistCount()
    {
        $db = \Config\Database::connect();
        $userID = session()->get('user_id');

        $query = "SELECT * FROM tbl_wishlist WHERE user_id = ? AND flag =1";
        $usercount = $db->query($query, [$userID])->getResultArray();
        if (!empty($usercount)) {
            $res = sizeof($usercount);
        } else {
            $res = 0;
        }
        return $res;
    }

    public function address()
    {

        $db = \Config\Database::connect();

        $res = $this->headerlist();
        // to get cart count 
        $userID = session()->get('user_id');
        if ($userID) {
            $countQuery = "SELECT COUNT(`prod_id`)  AS cart_count FROM tbl_user_cart WHERE  user_id = $userID AND   `flag` = 1";
            $cartCount = $db->query($countQuery)->getRow();
            $res['cart_count'] = $cartCount->cart_count;
        } else if ($userID = "") {
            $tempcount = session()->get('temp_count');
            $res['cart_count'] = $tempcount;
        } else {
            $res['cart_count'] = 0;
        }

        // to get wishlist count 
        $res['wishlist_count'] = $this->getWishlistCount();


        $res['state'] = $db->query("SELECT `state_id`,`state_title` FROM `tbl_state` WHERE `flag` =1")->getResultArray();

        $res['username'] = $db->query("SELECT `username`, email FROM `tbl_users` WHERE `user_id` = $userID ")->getResultArray();


        $query = "SELECT a.*, b.state_title, c.dist_name 
        FROM tbl_user_address AS a 
        INNER JOIN tbl_state AS b ON a.state_id = b.state_id
        INNER JOIN tbl_district AS c ON a.dist_id = c.dist_id
        WHERE a.user_id = $userID  AND a.flag = 1;";
        $res['address'] = $db->query($query, [$userID])->getResultArray();

        return view("address", $res);

    }


    public function getprofile()
    {

        $db = \Config\Database::connect();
        $userID = session()->get('user_id');
        $query = "SELECT `username`,`email`,`wanumber`,`number`  FROM `tbl_users` WHERE `user_id` =  $userID  AND `flag` =1";
        $getData = $db->query($query)->getResultArray();

        echo json_encode($getData);
    }

    public function updateprofile()
    {
        $this->session = \Config\Services::session();

        $db = \Config\Database::connect();

        $username = $this->request->getPost('username');
        $number = $this->request->getPost('number');
        $email = $this->request->getPost('email');
        $waNum = $this->request->getPost('wanumber');

        $userID = session()->get('user_id');

        $query = "UPDATE tbl_users 
          SET `username` = ?, `number` = ?, `email` = ? ,`wanumber` = ?
          WHERE flag = 1 AND `user_id` = ?";

        $result = $db->query($query, [$username, $number, $email, $waNum, $userID]);

        $affectedRows = $db->affectedRows();

        if ($result && $affectedRows == 1) {

            $sess = [
                'username' => $username,
            ];
            $this->session->set($sess);
            $res['code'] = 200;
            $res['msg'] = 'Data updates Successfully';
            $res['status'] = 'success';
            $res['csrf_test_name'] = csrf_hash();
            echo json_encode($res);
        } else {
            $res['code'] = 400;
            $res['msg'] = 'Data updates Failed';
            $res['status'] = 'failure';
            $res['csrf_test_name'] = csrf_hash();
            echo json_encode($res);
        }
    }

}