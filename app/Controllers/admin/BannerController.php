<?php

namespace App\Controllers\admin;

use App\Models\admin\BannerModal;

class BannerController extends BaseController
{

    public function banner()
    {
        $db = \Config\Database::connect();

        $session = \Config\Services::session();

        if ($session->get('login_sts') == "") {
            return redirect()->to('admin');
        } else {
            return view('admin/banner');
        }
    }

    public function Insertbanner()
    {
        $db = \Config\Database::connect();
        $banner = new BannerModal();

        $uploadPath = './uploads/';
        $dbPath = '/uploads/';

        $desktopImg = $this->request->getFile('desktop_img');
        $mobileImg = $this->request->getFile('mobile_img');

        $data = [];


        if ($desktopImg && $desktopImg->isValid() && !$desktopImg->hasMoved()) {
            $desktopName = $desktopImg->getRandomName();
            $desktopImg->move($uploadPath, $desktopName);

            $data['desktop_img'] = $dbPath . $desktopName;
        }


        if ($mobileImg && $mobileImg->isValid() && !$mobileImg->hasMoved()) {
            $mobileName = $mobileImg->getRandomName();
            $mobileImg->move($uploadPath, $mobileName);

            $data['mobile_img'] = $dbPath . $mobileName;
        }



        $banner->insert($data);



        $affectedRows = $db->affectedRows();
        if ($affectedRows == 1) {
            $result['code'] = 200;
            $result['msg'] = 'Data Inserted Successfully';
            $result['status'] = 'success';
            echo json_encode($result);
        } else {
            $result['code'] = 400;
            $result['msg'] = 'Something Wrong';
            $result['status'] = 'failure';
            echo json_encode($result);
        }
    }


    public function getbanner()
    {
        $db = \Config\Database::connect();
        $res = $db->query("SELECT * FROM tbl_banner WHERE flag = 1")->getResultArray();
        echo json_encode($res);
    }

    public function updatebanner()
    {
        $db = \Config\Database::connect();
        $modal = new BannerModal;

        $validation = service('validation');

        $validation->setRules([
            'mobile_img' => 'uploaded[mobile_img]|max_size[mobile_img,1024]|is_image[mobile_img]',
            'desktop_img' => 'uploaded[desktop_img]|max_size[desktop_img,1024]|is_image[desktop_img]'

        ]);
        $bannerID = $this->request->getPost('banner_id');

        if ($this->request->getFile('mobile_img')->isValid()) {
            $image_file1 = $this->request->getFile('mobile_img');
            $newImageFile1 = $image_file1->getRandomName();
            $prodname1 = str_replace(" ", "_", $newImageFile1);
            $filepath = '/uploads/';
            $image_file1->move('./uploads/', $newImageFile1);
            $data['mobile_img'] = $filepath . $prodname1;
        }

        if ($this->request->getFile('desktop_img')->isValid()) {
            $image_file2 = $this->request->getFile('desktop_img');
            $newImageFile2 = $image_file2->getRandomName();
            $prodname2 = str_replace(" ", "_", $newImageFile2);
            $filepath = '/uploads/';
            $image_file2->move('./uploads/', $newImageFile2);
            $data['desktop_img'] = $filepath . $prodname2;
        }

        $data['link'] = $this->request->getPost('link');

        $modal->update($bannerID, $data);

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


    public function deletebanner()
    {

        $db = \Config\Database::connect();

        $banner_id = $this->request->getPost();

        $query = 'UPDATE `tbl_banner` SET `flag`= 0 WHERE `banner_id` = ?';
        $updateData = $db->query($query, [$banner_id]);

        $affected_rows = $db->affectedRows();

        if ($affected_rows && $updateData) {
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
