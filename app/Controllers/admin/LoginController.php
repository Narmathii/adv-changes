<?php
namespace App\Controllers\admin;

use App\Models\admin\LoginModel;

class LoginController extends BaseController
{


    public function login()
    {
        return view('admin/login');
    }

    public function checkLogin()
    {
        $db = \Config\Database::connect();
        $this->session = \Config\Services::session();

        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $loginModel = new LoginModel;

        $userData = $loginModel->where('username', $username)->first();

        $resultData = [];

        if ($userData) {
            $pwd = $userData['password'];
            if ($pwd === $password) {
                $ses_data = [
                    'admin_name' => $userData['username'],
                    'alogin_sts' => $userData['password'],
                    'auser_type' => $userData['user_type'],
                    'login_sts' => "YES"
                ];
                $this->session->set($ses_data);

                $resultData['message'] = 'success';
                $resultData['code'] = '200';
                $resultData['csrf'] = csrf_hash();
            } else {
                $resultData['message'] = 'Incorrect username or password';
                $resultData['code'] = '400';
                $resultData['csrf'] = csrf_hash();
            }
        }

        return $this->response->setJSON($resultData);
    }

    public function logout()
    {
        $session = $this->session = \Config\Services::session();

        $session->destroy();

        // Prevent caching
        return redirect()->to('admin');
    }
}