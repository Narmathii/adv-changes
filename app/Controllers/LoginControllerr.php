<?php
namespace App\Controllers;

use App\Models\LoginModel;
use CodeIgniter\Config\Services;
use App\Libraries\MailjetService;

use Firebase\JWT\JWT;

// use App\Libraries\TwoFactorApi;

$security = \Config\Services::security();

class LoginControllerr extends BaseController
{

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

  private function setPendingOtpSession($userId, $username, $type, $flow)
  {
    $this->session = \Config\Services::session();

    $sess = [
      'type' => $type,
      'pending_user_id' => $userId,
      'pending_username' => $username,
      'pending_flow' => $flow,
      'pending_callback_url' => session()->get('callback_url')
    ];

    $this->session->set($sess);
  }

  private function clearPendingOtpSession()
  {
    $this->session = \Config\Services::session();
    $this->session->remove([
      'pending_user_id',
      'pending_username',
      'pending_flow',
      'pending_callback_url'
    ]);
  }

  private function normalizeMobileNumber($mobile)
  {
    return preg_replace('/\D+/', '', (string) $mobile);
  }

  private function isValidMobileNumber($mobile)
  {
    return preg_match('/^[6-9]\d{9}$/', $mobile) === 1;
  }

  public function login()
  {

    $db = \Config\Database::connect();
    $res = $this->headerlist();

    // to get wishlist count 
    $res['wishlist_count'] = $this->getWishlistCount();


    // to get cart count 
    $userID = session()->get('user_id');
    $query = "SELECT * FROM tbl_user_cart WHERE user_id = ?";
    $usercount = $db->query($query, [$userID])->getResultArray();
    if ($usercount > 0) {
      $res['cart_count'] = sizeof($usercount);

    } else {
      $res['cart_count'] = 0;
    }
    // end cart count

    return view('login', $res);
  }
  public function signup()
  {
    $previousUrl = previous_url();

    $db = \Config\Database::connect();
    $res = $this->headerlist();

    $res['prev_url'] = $previousUrl;

    // to get cart count 
    $userID = session()->get('user_id');
    $query = "SELECT * FROM tbl_user_cart WHERE user_id = ?";
    $usercount = $db->query($query, [$userID])->getResultArray();
    if ($usercount > 0) {
      $res['cart_count'] = sizeof($usercount);

    } else {
      $res['cart_count'] = 0;
    }
    // end cart count

    // to get wishlist count 
    $res['wishlist_count'] = $this->getWishlistCount();

    return view('signup', $res);
  }

  public function password()
  {
    $db = \Config\Database::connect();
    $res = $this->headerlist();


    // to get cart count 
    $userID = session()->get('user_id');
    $query = "SELECT * FROM tbl_user_cart WHERE user_id = ?";
    $usercount = $db->query($query, [$userID])->getResultArray();
    if ($usercount > 0) {
      $res['cart_count'] = sizeof($usercount);
    } else {
      $res['cart_count'] = 0;
    }
    // end cart count

    // to get wishlist count 
    $res['wishlist_count'] = $this->getWishlistCount();

    return view('password', $res);
  }

  public function resetPassword($id)
  {
    $encryptedUserId = $this->request->uri->getSegment(2);

    $res = explode('-', $encryptedUserId);
    $getId = $res[1];

    $decrpt1 = base64_decode($getId);
    $decrpt2 = base64_decode($decrpt1);

    $res['user_id'] = $decrpt2;

    $db = \Config\Database::connect();
    $res = $this->headerlist();

    // to get cart count 
    $userID = session()->get('user_id');
    $query = "SELECT * FROM tbl_user_cart WHERE user_id = ?";
    $usercount = $db->query($query, [$userID])->getResultArray();
    if ($usercount > 0) {
      $res['cart_count'] = sizeof($usercount);

    } else {
      $res['cart_count'] = 0;
    }
    // end cart count


    // to get wishlist count 
    $res['wishlist_count'] = $this->getWishlistCount();


    return view('resetPassword', $res);
  }

  // ***************************************************************** SIGNUP FROM MAIL *********************************************************************
  public function signupEmailCheck()
  {
    $this->session = \Config\Services::session();

    $db = \Config\Database::connect();
    $loginModel = new LoginModel;
    $response = [];

    $username = $this->request->getPost('username');
    $number = $this->normalizeMobileNumber($this->request->getPost('number'));
    $useremail = $this->request->getPost('email');
    $pwd = $this->request->getPost('password');

    if (!$this->isValidMobileNumber($number)) {
      $response['code'] = 400;
      $response['msg'] = 'Please enter a valid mobile number';
      return json_encode($response);
    }


    $query = "SELECT COUNT('user_id') AS  count FROM `tbl_users` WHERE `number` = ? AND `flag` = 1";
    $number_count = $db->query($query, [$number])->getRow();

    $query1 = "SELECT COUNT('user_id') AS count FROM `tbl_users` WHERE `email` = ? AND `flag` = 1";
    $email_count = $db->query($query1, [$useremail])->getRow();


    if ($number_count->count != 0) {

      $response['code'] = 400;
      $response['msg'] = 'The mobile number has already been registered';
      return json_encode($response);
    } else if ($email_count->count != 0) {
      $response['code'] = 400;
      $response['msg'] = 'The Email has already been registered';
      return json_encode($response);
    } else {
      $otp = rand(1000, 9999);


      // Email using Mail jet
      $mailjet = new MailjetService();
      $toEmail = $useremail;
      $toName = $username;
      $subject = "Customer Account Confirmation!";
      $body = '
         <h1 style="text-align:left">Welcome to Adventure Shoppe!!<h1>
         <p style="text-align:left;font-size:18px;color:black">To complete the activation process of your account, 
              please enter the One-Time Password (OTP) provided to you.<p> 
        
         <div >
         <p>Your OTP :</p><button type="button" style="padding:20px 45px;background-color:#0c0c0c;color:#ffff;font-size:25px;border-radius:10px;
          font-weight: bold;display:flex;justify-content:center;align-items:center;">' . $otp . '</button>
         </div>';

      $result = $mailjet->sendEmail($toEmail, $toName, $subject, $body);
      if ($result) {
        $data = [
          'username' => $username,
          'number' => $number,
          'password' => $pwd,
          'email' => $useremail,
          'otp' => $otp,
          'flag' => 0,
        ];

        $insertData = $loginModel->insert($data);
        $lastInsertID = $db->insertID();
        $affectedRows = $db->affectedRows();

        if ($affectedRows === 1 && $insertData) {
          $this->setPendingOtpSession($lastInsertID, $username, 'EMAIL', 'SIGNUP_EMAIL');

          $response['code'] = 200;
          $response['user_id'] = $lastInsertID;
          $response['username'] = $username;
          $response['msg'] = 'OTP sent successfully';
          $response['csrf_test_name'] = csrf_hash();
          return json_encode($response);
        } else {
          $response['code'] = 400;
          $response['msg'] = 'Unable to process signup';
          $response['csrf_test_name'] = csrf_hash();
          return json_encode($response);
        }
      }
    }

  }

  public function verifyEmailOTP()
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


    // to get cart count 
    $userID = session()->get('user_id');
    $query = "SELECT * FROM tbl_user_cart WHERE user_id = ?";
    $usercount = $db->query($query, [$userID])->getResultArray();
    if ($usercount > 0) {
      $res['cart_count'] = sizeof($usercount);

    } else {
      $res['cart_count'] = 0;
    }
    // end cart count

    // to get wishlist count 
    $res['wishlist_count'] = $this->getWishlistCount();


    return view('verifyEmailOTP', $res);
  }


  public function checkEmailOTP()
  {

    $session = $this->session = \Config\Services::session();
    $db = \Config\Database::connect();

    $verifyOTP = $this->request->getPost('verify-otp');

    $userID = session()->get('pending_user_id') ?? session()->get('user_id');
    $pendingFlow = session()->get('pending_flow');

    if (!$userID) {
      $res['code'] = 400;
      $res['status'] = 'failure';
      $res['msg'] = 'Session expired. Please try again.';
      $res['csrf_test_name'] = csrf_hash();
      return $this->response->setJSON($res);
    }

    $OTP = $db->query("SELECT `otp`, username, user_id FROM `tbl_users` WHERE user_id = ?", [$userID])->getRow();

    if (!$OTP) {
      $res['code'] = 400;
      $res['status'] = 'failure';
      $res['msg'] = 'User not found.';
      $res['csrf_test_name'] = csrf_hash();
      return $this->response->setJSON($res);
    }

    $username = $OTP->username;
    $userID = $OTP->user_id;

    if ($OTP->otp == $verifyOTP) {
      if ($pendingFlow === 'SIGNUP_EMAIL') {
        $db->query("UPDATE `tbl_users` SET `flag` = 1 WHERE `user_id` = ?", [$userID]);
      }

      $callbackURL = session()->get('pending_callback_url');
      if ($callbackURL) {
        $session->remove('callback_url');
      }

      $response = [
        'code' => 200,
        'user_id' => $userID,
        'username' => $username,
        'c_url' => $callbackURL ?: ""
      ];

      $this->clearPendingOtpSession();

      $finalResponse = json_decode($this->replaceloginSession($response), true);
      return $this->response->setJSON($finalResponse);
    } else {
      $res['code'] = 400;
      $res['status'] = 'failure';
      $res['msg'] = 'Invalid OTP !!';
      $res['csrf_test_name'] = csrf_hash();
    }
    return $this->response->setJSON($res);

  }

  public function signupSessionEmail($response)
  {
    if ($response['code'] == 200) {

      $db = \Config\Database::connect();
      $this->session = \Config\Services::session();

      $data = $this->request->getPost();
      $oldSession = session()->get('user_id');
      $newSession = $response['user_id'];
      $username = $response['username'];

      // Check cart table if any of the products stored in session?
      $query = "SELECT * FROM tbl_user_cart WHERE user_id = ? AND flag = 1";
      $resultData = $db->query($query, [$oldSession])->getResultArray();

      if (count($resultData) > 0) {
        foreach ($resultData as $item) {
          $prodID = $item['prod_id'];
          $tblName = $item['table_name'];
          $query = "SELECT * FROM tbl_user_cart WHERE prod_id = ? AND user_id = ? AND table_name = ? AND flag = 1";
          $count = $db->query($query, [$prodID, $oldSession, $tblName])->getNumRows();

          if ($count > 0) {
            $qty = $item['quantity'];
            $updateQry = "UPDATE tbl_user_cart 
                                  SET user_id = ?, quantity = quantity + ? 
                                  WHERE user_id = ? AND prod_id = ? AND table_name = ? AND flag = 1";
            $db->query($updateQry, [$newSession, $qty, $oldSession, $prodID, $tblName]);
          }
        }
      }


      $jwtSecret = $_ENV['JWT_SECRET'];

      $newToken = $this->generateJWT($newSession, $jwtSecret);


      $sess = [
        'name' => $newSession,
        'username' => $username,
        'user_id' => $newSession,
        'loginStatus' => "YES",
        'otp_verify' => "NO",
        'type' => 'EMAIL',
        'jwt' => $newToken
      ];

      $this->session->set($sess);

      $response['code'] = 200;
      $response['message'] = 'Logged in successfully';
      $response['token'] = $newToken;
      $response['csrf_test_name'] = csrf_hash();
      return json_encode($response);
    } else {
      $response['code'] = 400;
      $response['message'] = 'Invalid Email or Password';
      $response['csrf_test_name'] = csrf_hash();
      return json_encode($response);
    }
  }

  public function resendEmailOTP()
  {
    $this->session = \Config\Services::session();
    $db = \Config\Database::connect();
    $userID = session()->get('pending_user_id') ?? session()->get('user_id');
    $getEmail = $db->query("SELECT `email` ,`username` FROM `tbl_users` WHERE user_id = ?", [$userID])->getRow();

    $userEmail = $getEmail->email;
    $userName = $getEmail->username;

    $otp = rand(1000, 9999);

    // ResendEmail using Mail jet
    $mailjet = new MailjetService();
    $toEmail = $userEmail;
    $toName = $userName;
    $subject = "Customer Account Confirmation!";
    $body = '
         <h1 style="text-align:left">Welcome to Adventure Shoppe!!<h1>
         <p style="text-align:left;font-size:18px;color:black">To complete the activation process of your account, 
              please enter the One-Time Password (OTP) provided to you.<p> 
        
         <div >
         <p>Your OTP :</p><button type="button" style="padding:20px 45px;background-color:#0c0c0c;color:#ffff;font-size:25px;border-radius:10px;
          font-weight: bold;display:flex;justify-content:center;align-items:center;">' . $otp . '</button>
         </div>';

    $result = $mailjet->sendEmail($toEmail, $toName, $subject, $body);
    if ($result) {
      $query = "UPDATE tbl_users SET otp = ? WHERE user_id = ?";
      $update = $db->query($query, [$otp, $userID]);
      $affectedRow = $db->affectedRows();

      if ($update && $affectedRow == 1) {
        $res['code'] = 200;
        $res['status'] = 'Success';
        $res['msg'] = 'Check Your Email!';

        echo json_encode($res);
      } else {
        $res['code'] = 400;
        $res['status'] = 'Failure';
        $res['msg'] = 'Invalid Email!';
        echo json_encode($res);
      }
    }
  }



  // ***************************************************************** SIGNUP FROM SMS  START *********************************************************************


  public function signupOTP()
  {
    $db = \Config\Database::connect();
    $to = $this->normalizeMobileNumber($this->request->getPost('number'));
    $uname = $this->request->getPost('uname');

    $data = $this->request->getPost();

    if (!$this->isValidMobileNumber($to)) {
      $res['code'] = 400;
      $res['msg'] = 'Please enter a valid mobile number';
      return json_encode($res);
    }

    $apiKey = $_ENV['SMS_API_KEY'];

    $sign1 = $_ENV['SIGNUP_TEMPLATE1'];
    $sign2 = $_ENV['SIGNUP_TEMPLATE2'];
    $sign3 = $_ENV['SIGNUP_TEMPLATE3'];


    $templates = [$sign1, $sign2, $sign3];

    // Randomly select one template from the array
    $templateName = $templates[array_rand($templates)];
    $otp = rand(1000, 9999);

    // Authentication 
    $qry = "SELECT `username`, `number` FROM `tbl_users` WHERE  number = ? AND `flag` = 1";
    $savedData = $db->query($qry, [$to])->getResultArray();

    if (count($savedData) > 0) {
      $res['code'] = 400;
      $res['msg'] = 'Number already registered.';
      echo json_encode($res);
    } else {

      // $response = $this->signupAPI($apiKey, $to, $otp, $templateName);
      // $status = $response['Status'];
      $status = "Success";


      if ($status == "Success") {
        $query = "INSERT INTO tbl_users (username , number , otp, flag) VALUES ( ? , ? ,?, 0)";
        $insertData = $db->query($query, [$uname, $to, $otp]);
        $affectedRows = $db->affectedRows();
        $lastInsertID = $db->insertID();

        if ($affectedRows == 1) {
          $this->setPendingOtpSession($lastInsertID, $uname, 'SMS', 'SIGNUP_SMS');

          $response['code'] = 200;
          $response['user_id'] = $lastInsertID;
          $response['username'] = $uname;
          $response['msg'] = 'OTP sent successfully';
          $response['csrf_test_name'] = csrf_hash();
          return json_encode($response);

        } else {
          $response['code'] = 400;
          $response['msg'] = 'Unable to process signup';
          $response['csrf_test_name'] = csrf_hash();
          return json_encode($response);
        }

      } else {
        $response['code'] = 400;
        $response['msg'] = 'Unable to send OTP';
        $response['csrf_test_name'] = csrf_hash();
        return json_encode($response);
      }
    }
  }

  public function signupOtppage()
  {
    $db = \Config\Database::connect();

    $res = $this->headerlist();

    // to get cart count 
    $userID = session()->get('user_id');
    $query = "SELECT * FROM tbl_user_cart WHERE user_id = ?";
    $usercount = $db->query($query, [$userID])->getResultArray();
    if ($usercount > 0) {
      $res['cart_count'] = sizeof($usercount);

    } else {
      $res['cart_count'] = 0;
    }
    // end cart count

    // to get wishlist count 
    $res['wishlist_count'] = $this->getWishlistCount();


    return view('signupOtppage', $res);
  }

  public function checkSmsOTP()
  {

    $session = $this->session = \Config\Services::session();
    $db = \Config\Database::connect();

    $verifyOTP = $this->request->getPost('verify-otp');

    $userID = session()->get('pending_user_id') ?? session()->get('user_id');
    $pendingFlow = session()->get('pending_flow');

    if (!$userID) {
      $res['code'] = 400;
      $res['status'] = 'failure';
      $res['msg'] = 'Session expired. Please try again.';
      $res['csrf_test_name'] = csrf_hash();
      return $this->response->setJSON($res);
    }

    $OTP = $db->query("SELECT `otp`, username, user_id FROM `tbl_users` WHERE user_id = ?", [$userID])->getRow();

    if (!$OTP) {
      $res['code'] = 400;
      $res['status'] = 'failure';
      $res['msg'] = 'User not found.';
      $res['csrf_test_name'] = csrf_hash();
      return $this->response->setJSON($res);
    }

    $username = $OTP->username;
    $userID = $OTP->user_id;

    if ($OTP->otp == $verifyOTP) {
      if ($pendingFlow === 'SIGNUP_SMS') {
        $db->query("UPDATE `tbl_users` SET `flag` = 1 WHERE `user_id` = ?", [$userID]);
      }

      $callbackURL = session()->get('pending_callback_url');
      if ($callbackURL) {
        $session->remove('callback_url');
      }

      $response = [
        'code' => 200,
        'user_id' => $userID,
        'username' => $username,
        'c_url' => $callbackURL ?: ""
      ];

      $this->clearPendingOtpSession();

      $finalResponse = json_decode($this->replaceloginSession($response), true);
      return $this->response->setJSON($finalResponse);
    } else {
      $res['code'] = 400;
      $res['status'] = 'failure';
      $res['msg'] = 'Invalid OTP !!';
      $res['csrf_test_name'] = csrf_hash();
    }
    return $this->response->setJSON($res);

  }

  public function resendSignUpOTP()
  {
    $this->session = \Config\Services::session();
    $db = \Config\Database::connect();
    $userID = session()->get('pending_user_id') ?? session()->get('user_id');
    $Type = session()->get('type');


    if ($Type == "SMS") {
      $details = $db->query("SELECT `number` FROM `tbl_users` WHERE user_id = ?", [$userID])->getRow();
      $to = $details->number;

      $sign1 = $_ENV['SIGNUP_TEMPLATE1'];
      $sign2 = $_ENV['SIGNUP_TEMPLATE2'];
      $sign3 = $_ENV['SIGNUP_TEMPLATE3'];

      $templates = [$sign1, $sign2, $sign3];

      // Randomly select one template from the array
      $templateName = $templates[array_rand($templates)];
      $otp = rand(1000, 9999);
      $apiKey = $_ENV['SMS_API_KEY'];

      $response = $this->signupAPI($apiKey, $to, $otp, $templateName);
      $status = $response['Status'];

      if ($status == "Success") {
        $query = "UPDATE tbl_users SET otp = ? WHERE user_id = ?";
        $update = $db->query($query, [$otp, $userID]);
        $affectedRow = $db->affectedRows();

        if ($update && $affectedRow == 1) {
          $res['code'] = 200;
          $res['status'] = 'Success';
          $res['msg'] = 'Check your phone for OTP verification!';

          echo json_encode($res);
        } else {
          $res['code'] = 400;
          $res['status'] = 'Failure';
          $res['msg'] = 'Invalid Number!';
          echo json_encode($res);
        }
      }

    } else if ($Type == "EMAIL") {

      $getEmail = $db->query("SELECT `email` ,`username` FROM `tbl_users` WHERE user_id = ?", [$userID])->getRow();

      $userEmail = $getEmail->email;
      $userName = $getEmail->username;

      $otp = rand(1000, 9999);

      $subject = 'Customer Account Confirmation!';
      $message = '
         <h1 style="text-align:left">Welcome to Adventure Shoppe!!<h1>
         <p style="text-align:left;font-size:18px;color:black">To complete the activation process of your account, 
              please enter the One-Time Password (OTP) provided to you.<p> 
        
         <div >
         <p>Your OTP :</p><button type="button" style="padding:20px 45px;background-color:#0c0c0c;color:#ffff;font-size:25px;border-radius:10px;
          font-weight: bold;display:flex;justify-content:center;align-items:center;">' . $otp . '</button>
         </div>';

      $email = Services::email();

      $email->setFrom('abhishek@adventureshoppe.com', 'Adventureshoppe');
      $email->setTo($userEmail);
      $email->setSubject($subject);
      $email->setMessage($message);

      if ($email->send()) {
        $query = "UPDATE tbl_users SET otp = ? WHERE user_id = ?";
        $update = $db->query($query, [$otp, $userID]);
        $affectedRow = $db->affectedRows();

        if ($update && $affectedRow == 1) {
          $res['code'] = 200;
          $res['status'] = 'Success';
          $res['msg'] = 'Check Your Email!';

          echo json_encode($res);
        } else {
          $res['code'] = 400;
          $res['status'] = 'Failure';
          $res['msg'] = 'Invalid Email!';
          echo json_encode($res);
        }
      }
    }

  }


  public function signupSessionSMS($response)
  {

    if ($response['code'] == 200) {

      $db = \Config\Database::connect();
      $this->session = \Config\Services::session();

      $data = $this->request->getPost();
      $oldSession = session()->get('user_id');
      $newSession = $response['user_id'];
      $username = $response['username'];

      // Check cart table if any of the products stored in session?
      $query = "SELECT * FROM tbl_user_cart WHERE user_id = ? AND flag = 1";
      $resultData = $db->query($query, [$oldSession])->getResultArray();

      if (count($resultData) > 0) {
        foreach ($resultData as $item) {
          $prodID = $item['prod_id'];
          $tblName = $item['table_name'];
          $query = "SELECT * FROM tbl_user_cart WHERE prod_id = ? AND user_id = ? AND table_name = ? AND flag = 1";
          $count = $db->query($query, [$prodID, $oldSession, $tblName])->getNumRows();

          if ($count > 0) {
            $qty = $item['quantity'];
            $updateQry = "UPDATE tbl_user_cart 
                                  SET user_id = ?, quantity = quantity + ? 
                                  WHERE user_id = ? AND prod_id = ? AND table_name = ? AND flag = 1";
            $db->query($updateQry, [$newSession, $qty, $oldSession, $prodID, $tblName]);
          }
        }
      }

      $jwtSecret = $_ENV['JWT_SECRET'];

      $newToken = $this->generateJWT($newSession, $jwtSecret);

      $sess = [
        'name' => $newSession,
        'username' => $username,
        'user_id' => $newSession,
        'loginStatus' => "YES",
        'otp_verify' => "NO",
        'type' => 'SMS',
        'jwt' => $newToken
      ];
      $this->session->set($sess);

      $response['code'] = 200;
      $response['message'] = 'Logged in successfully';
      $response['csrf_test_name'] = csrf_hash();
      $response['token'] = $newToken;

      echo "<pre>";
      print_r($response);
      die;
      return json_encode($response);
    } else {
      $response['code'] = 400;
      $response['message'] = 'Invalid Number';
      $response['csrf_test_name'] = csrf_hash();
      return json_encode($response);
    }
  }

  private function signupAPI($apiKey, $to, $otp, $templateName)
  {
    $client = \Config\Services::curlrequest();
    try {
      $url = 'https://2factor.in/API/V1/' . $apiKey . '/SMS/' . urlencode('+91' . $to) . '/' . urlencode($otp) . '/' . urlencode($templateName);
      log_message('debug', 'Requesting URL: ' . $url);
      $response = $client->get($url);
      $responseData = json_decode($response->getBody(), true);

      return $responseData;
    } catch (\Exception $e) {
      log_message('error', 'cURL Error: ' . $e->getCode() . ' : ' . $e->getMessage());
      return false;
    }
  }

  // ***************************************************************** SIGNUP FROM SMS END  *********************************************************************


  // ***************************************************************** LOGIN FROM SMS START  *********************************************************************

  public function loginOTP()
  {

    $session = $this->session = \Config\Services::session();

    $db = \Config\Database::connect();
    $to = $this->normalizeMobileNumber($this->request->getPost('num'));

    $response = [];
    $loginModel = new LoginModel;

    if (!$this->isValidMobileNumber($to)) {
      $response['code'] = '400';
      $response['message'] = 'Please enter a valid mobile number';
      return json_encode($response);
    }

    $query = "SELECT * FROM `tbl_users` WHERE `flag` = 1 AND `number` = ?";
    $userData = $db->query($query, [$to])->getResultArray();
    if (count($userData) > 0) {
      $userID = $userData[0]['user_id'];

      // for login otp
      $login1 = $_ENV['LOGIN_TEMPLATE1'];
      $login2 = $_ENV['LOGIN_TEMPLATE2'];
      $login3 = $_ENV['LOGIN_TEMPLATE3'];

      $templates = [$login1, $login2, $login3];

      // Randomly select one template from the array
      $templateName = $templates[array_rand($templates)];
      $otp = rand(1000, 9999);
      $apiKey = $_ENV['SMS_API_KEY'];

      $res = $this->signupAPI($apiKey, $to, $otp, $templateName);
      $status = $res['Status'];
      if ($status == "Success") {
        $query = "UPDATE tbl_users SET otp = ? WHERE user_id = ? AND number = ? AND flag = 1";
        $insertData = $db->query($query, [$otp, $userID, $to]);
        $affectedRows = $db->affectedRows();
        if ($affectedRows == 1) {
          $response['code'] = '200';
          $response['user_id'] = $userID;
          $response['username'] = $userData[0]['username'];
          $response['msg'] = 'OTP sent successfully';
          $response['csrf_test_name'] = csrf_hash();
          $this->setPendingOtpSession($userID, $userData[0]['username'], 'SMS', 'LOGIN_SMS');
          return json_encode($response);
        }


      } else {
        $response['code'] = '400';
        $response['message'] = 'Invalid Number';
        return json_encode($response);
      }
    } else {
      $response['code'] = '400';
      $response['message'] = 'Invalid Number';
      echo json_encode($response);
    }

  }

  public function LoginOTPpage()
  {
    $db = \Config\Database::connect();

    $res = $this->headerlist();

    // to get cart count 
    $userID = session()->get('user_id');
    $query = "SELECT * FROM tbl_user_cart WHERE user_id = ?";
    $usercount = $db->query($query, [$userID])->getResultArray();
    if ($usercount > 0) {
      $res['cart_count'] = sizeof($usercount);

    } else {
      $res['cart_count'] = 0;
    }
    // end cart count

    // to get wishlist count 
    $res['wishlist_count'] = $this->getWishlistCount();

    return view('loginOTPpage', $res);
  }
  public function LoginOTPVerify()
  {
    $this->session = \Config\Services::session();
    $db = \Config\Database::connect();
    $userID = session()->get('pending_user_id') ?? session()->get('user_id');
    $Type = session()->get('type');


    if ($Type == "SMS") {
      $details = $db->query("SELECT `number` FROM `tbl_users` WHERE user_id = ?", [$userID])->getRow();
      $to = $details->number;
      $otp = rand(1000, 9999);

      $apiKey = $_ENV['SMS_API_KEY'];
      // for login otp
      $login1 = $_ENV['LOGIN_TEMPLATE1'];
      $login2 = $_ENV['LOGIN_TEMPLATE2'];
      $login3 = $_ENV['LOGIN_TEMPLATE3'];

      $templates = [$login1, $login2, $login3];

      // Randomly select one template from the array
      $templateName = $templates[array_rand($templates)];

      $response = $this->signupAPI($apiKey, $to, $otp, $templateName);
      $status = $response['Status'];

      if ($status == "Success") {
        $query = "UPDATE tbl_users SET otp = ? WHERE user_id = ?";
        $update = $db->query($query, [$otp, $userID]);
        $affectedRow = $db->affectedRows();

        if ($update && $affectedRow == 1) {
          $res['code'] = 200;
          $res['status'] = 'Success';
          $res['msg'] = 'Check your phone for OTP verification!';

          echo json_encode($res);
        } else {
          $res['code'] = 400;
          $res['status'] = 'Failure';
          $res['msg'] = 'Invalid Number!';
          echo json_encode($res);
        }
      }

    } else if ($Type == "EMAIL") {

      $getEmail = $db->query("SELECT `email` ,`username` FROM `tbl_users` WHERE user_id = ?", [$userID])->getRow();

      $userEmail = $getEmail->email;
      $userName = $getEmail->username;

      $otp = rand(1000, 9999);


      $subject = 'Customer Account Confirmation!';
      $message = '
         <h1 style="text-align:left">Welcome to Adventure Shoppe!!<h1>
         <p style="text-align:left;font-size:18px;color:black">To complete the activation process of your account, 
              please enter the One-Time Password (OTP) provided to you.<p> 
        
         <div >
         <p>Your OTP :</p><button type="button" style="padding:20px 45px;background-color:#0c0c0c;color:#ffff;font-size:25px;border-radius:10px;
          font-weight: bold;display:flex;justify-content:center;align-items:center;">' . $otp . '</button>
         </div>';

      $email = Services::email();


      $email->setFrom('abhishek@adventureshoppe.com', 'Adventureshoppe');
      $email->setTo($userEmail);
      $email->setSubject($subject);
      $email->setMessage($message);

      if ($email->send()) {
        $query = "UPDATE tbl_users SET otp = ? WHERE user_id = ?";
        $update = $db->query($query, [$otp, $userID]);
        $affectedRow = $db->affectedRows();

        if ($update && $affectedRow == 1) {
          $res['code'] = 200;
          $res['status'] = 'Success';
          $res['msg'] = 'Check Your Email!';

          echo json_encode($res);
        } else {
          $res['code'] = 400;
          $res['status'] = 'Failure';
          $res['msg'] = 'Invalid Email!';
          echo json_encode($res);
        }
      }
    }

  }

  // ***************************************************************** Login Check  *********************************************************************
  public function checkLogin()
  {

    $session = $this->session = \Config\Services::session();

    $response = [];
    $loginModel = new LoginModel;

    $email = $this->request->getPost('email');
    $pwd = $this->request->getPost('password');


    $userData = $loginModel->where('email', $email)->first();


    if ($userData != "") {
      $password = $userData['password'];

      if ($password === $pwd) {
        $callbackURL = session()->get('callback_url');
        if ($callbackURL) {
          $session->remove('callback_url');
          $response['c_url'] = $callbackURL;
        } else {
          $response['c_url'] = "myprofile";
        }
        $response['code'] = '200';
        $response['user_id'] = $userData['user_id'];
        $response['username'] = $userData['username'];
        return $this->replaceloginSession($response);

      } else {
        $response['code'] = '400';
        $response['message'] = 'Invalid password';
        return $this->replaceloginSession($response);

      }
    } else if ($userData == "") {
      $response['code'] = '400';
      $response['message'] = "Invalid email";
      return json_encode($response);
    }
    return $this->response->setJSON($response);
  }
  public function Logout()
  {

    $this->session = \Config\Services::session();
    $session = session();
    $session->remove([
      'name',
      'username',
      'user_id',
      'loginStatus',
      'otp_verify',
      'jwt'
    ]);

    return redirect()->to('/');
  }


  public function replaceloginSession($response)
  {
    $request = service('request');

    if ($response['code'] == 200) {

      $db = \Config\Database::connect();
      $this->session = \Config\Services::session();

      $oldSession = session()->get('user_id');
      $newSession = $response['user_id'];
      $username = $response['username'];

      // Check cart table if any of the products stored in session?
      $query = "SELECT * FROM tbl_user_cart WHERE user_id = ? AND flag = 1";
      $resultData = $db->query($query, [$oldSession])->getResultArray();

      if (count($resultData) > 0) {
        foreach ($resultData as $item) {
          $prodID = $item['prod_id'];
          $tblName = $item['table_name'];
          $qty = $item['quantity'];

          $prodPrice = $item["prod_price"];
          $subtotal = $prodPrice * $qty;

          $IDpresntQuery = "SELECT * FROM tbl_user_cart WHERE prod_id = ? AND user_id = ? AND table_name = ? AND flag = 1";
          $countID = $db->query($IDpresntQuery, [$prodID, $newSession, $tblName])->getNumRows();
          if ($countID > 0) {

            $updateQry = "UPDATE tbl_user_cart 
                                  SET quantity = ? , sub_total = ? 
                                  WHERE user_id = ? AND prod_id = ? AND table_name = ? AND flag = 1";
            $updateOld = $db->query($updateQry, [$qty, $subtotal, $newSession, $prodID, $tblName]);

            $affectedRows = $db->affectedRows();
            if ($updateOld && $affectedRows == 1) {
              $dltsession = "DELETE FROM tbl_user_cart WHERE user_id = ?";
              $db->query($dltsession, $oldSession);
            }

            $db->query($updateQry, [$qty, $subtotal, $newSession, $prodID, $tblName]);
          } else {
            $query = "SELECT * FROM tbl_user_cart WHERE prod_id = ? AND user_id = ? AND table_name = ? AND flag = 1";
            $count = $db->query($query, [$prodID, $oldSession, $tblName])->getNumRows();

            if ($count > 0) {

              $updateQry = "UPDATE tbl_user_cart 
                                    SET user_id = ?, quantity = ?,sub_total = ?
                                    WHERE user_id = ? AND prod_id = ? AND table_name = ? AND flag = 1";
              $db->query($updateQry, [$newSession, $qty, $subtotal, $oldSession, $prodID, $tblName]);
            }
          }

        }
      }

      // ###### Check wishlist table is any of the roducts are stored or not?

      $query = "SELECT * FROM tbl_wishlist WHERE user_id = ? AND flag = 1";
      $resultData = $db->query($query, [$oldSession])->getResultArray();

      if (count($resultData) > 0) {
        foreach ($resultData as $item) {
          $query = "UPDATE tbl_wishlist SET user_id = ? WHERE user_id = ? AND flag = 1";
          $update = $db->query($query, [$newSession, $oldSession]);

          // Also update the product IDs associated with the wishlist
          $updateProductQuery = "UPDATE tbl_wishlist SET user_id = ? WHERE user_id = ? AND flag = 1";
          $updateProducts = $db->query($updateProductQuery, [$newSession, $oldSession]);
        }
      }


      /* Changeing userID in Frequently viewed products if the user loggin */
      $feqQry = "UPDATE frequent_products SET `user` = ? WHERE `user` = ? AND flag = 1";
      $updateData = $db->query($feqQry, [$newSession, $oldSession]);

      $jwtSecret = $_ENV['JWT_SECRET'];

      $newToken = $this->generateJWT($newSession, $jwtSecret);


      $sess = [
        'name' => $newSession,
        'username' => $username,
        'user_id' => $newSession,
        'loginStatus' => "YES",
        'otp_verify' => "YES",
        'jwt' => $newToken
      ];
      $this->session->set($sess);

      $response['code'] = 200;
      $response['message'] = 'Logged in successfully';
      $response['token'] = $newToken;
      $response['csrf_test_name'] = csrf_hash();
      return json_encode($response);
    } else {
      $response['code'] = 400;
      $response['message'] = 'Invalid Email or Password';
      $response['csrf_test_name'] = csrf_hash();
      return json_encode($response);
    }
  }


  public function replacewishlist($response)
  {
    print_r("hii");
    $response['code'] = 200;
  }


  private function generateJWT($userID, $secretKey)
  {

    $issuedAt = time();
    $expirationTime = $issuedAt + 3600; // Token valid for 1 hour

    $payload = [
      'iat' => $issuedAt,
      'exp' => $expirationTime,
      'data' => [
        'user_id' => $userID
      ]
    ];
    return JWT::encode($payload, $secretKey, 'HS256');
  }


  // ***************************************************************** Verify Password  *********************************************************************

  public function verifyPwd()
  {

    $loginModel = new LoginModel;
    $useremail = $this->request->getPost('email');
    $userData = $loginModel->where('email', $useremail)->where('flag', 1)->first();

    // encrypt start
    $userID = $userData['user_id'];

    $encode1ID = base64_encode($userID);


    $length = 22;
    $randomString = substr(str_shuffle('0123456789a$bcdefghijklmnopqrst_uvwxyzABCD$EFGHIJKL$MNOPQRSTUVWXYZ'), 0, $length);
    $encode2ID = base64_encode($encode1ID);
    $res = $randomString . '-' . $encode2ID . '-' . $randomString;


    $reset_url = "https://adventureshoppe.com/reset-password/" . $res;
    // $reset_url = "http://localhost/ci4projects/adventure/reset-password/" . $res;


    if ($useremail == $userData['email']) {

      $subject = 'Reset Customer Password';
      $message = '
         <h1 style="text-align:left">Reset Your Password!!<h1>
         <p style="text-align:left;font-size:18px;color:black">Use this link to reset your Adventure Shoppe account password. If you did not request a new password, you may safely ignore this email.</p> 
        
         <p style="text-align:left;font-size:18px;color:black">Click here to reset your Password:</p> 
<a href =' . $reset_url . '  style="text-align:left;font-size:16px;">Click here!!</a>';

      $email = Services::email();

      $email->setFrom('abhishek@adventureshoppe.com', 'Adventureshoppe');
      $email->setTo($useremail);
      $email->setSubject($subject);
      $email->setMessage($message);



      if ($email->send()) {
        $response['code'] = 200;
        $response['msg'] = 'Check your Email!!';

      }


    } else {
      $response['code'] = 400;
      $response['status'] = 'Failed';
      $response['msg'] = 'Email is not found!';
    }

    return $this->response->setJSON($response);
  }
  // ***************************************************************** Reset Password  *********************************************************************


  public function resetPwd()
  {


    $reset_id = $this->request->getPost('reset-id');

    $db = \Config\Database::connect();


    $newpwd = $this->request->getPost('new-password');
    $confirmPwd = $this->request->getPost('confirm-pwd');

    if ($newpwd === $confirmPwd) {
      $query =
        "UPDATE `tbl_users` SET `password` = ?  WHERE `user_id` = ? AND flag = 1";
      $updateData = $db->query($query, [$newpwd, $reset_id]);

      $affectedRows = $db->affectedRows();
      if ($affectedRows === 1 && $updateData) {
        $result['code'] = 200;
        $result['msg'] = 'Password Changed Successfully!';
        $result['status'] = 'success';

      } else {
        $result['code'] = 400;
        $result['status'] = 'Failed';
        $result['msg'] = 'Something wrong';

      }

    } else {
      $result['code'] = 400;
      $result['status'] = 'Failed';
      $result['msg'] = 'The passwords do not match.';
    }
    return $this->response->setJSON($result);
  }



}




