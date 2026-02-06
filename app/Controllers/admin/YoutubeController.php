<?php

namespace App\Controllers\admin;

use App\Models\admin\YoutubeModel;

class YoutubeController extends BaseController
{

    public function youtube()
    {

        $session = \Config\Services::session();

        if ($session->get('login_sts') == "") {
            return redirect()->to('admin');
        } else {
            return view('admin/youtube');
        }


    }

    public function insertYoutube()
    {

        $db = \Config\Database::connect();
        $youtube = new YoutubeModel();

        $ytubelink = $this->request->getPost("ytube_link");


        $validation = \Config\Services::validation();
        $validation->setRules([
            'ytube_img' => 'uploaded[ytube_img]|max_size[ytube_img,1024]|is_image[ytube_img]',


        ]);


        if (!$validation->withRequest($this->request)->run()) {
            $res = $validation->getErrors();
            $result['code'] = 400;
            $result['status'] = 'Failed';
            $result['msg'] = $res;
            echo json_encode($result);
        } else {
            $YtubeImg = $this->request->getFile('ytube_img');
            $YtubeImg->move('uploads/');
            $file_path1 = 'uploads/';
            $YtubeImgg = $YtubeImg->getName();

            $data = [
                'ytube_img' => $file_path1 . $YtubeImgg,
                'ytube_link' => $ytubelink
            ];


            $youtube->insert($data);
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


    }

    public function getYoutube()
    {
        $db = \Config\Database::connect();
        $res = $db->query("SELECT * FROM tbl_youtube WHERE flag = 1")->getResultArray();
        echo json_encode($res);
    }

    public function updateYoutube()
    {
        $db = \Config\Database::connect();
        $modall = new YoutubeModel;

        $validation = service('validation');

        $validation->setRules([
            'ytube_img' => 'uploaded[ytube_img]|max_size[ytube_img,1024]|is_image[ytube_img]',

        ]);
        $ytubeID = $this->request->getPost('ytube_id');

        if ($this->request->getFile('ytube_img')->isValid()) {
            $image_file1 = $this->request->getFile('ytube_img');
            $newImageFile1 = $image_file1->getName();
            $prodname1 = str_replace(" ", "_", $newImageFile1);
            $filepath = 'uploads/';
            $image_file1->move('uploads/', $newImageFile1);
            $data['ytube_img'] = $filepath . $prodname1;
        }
        $data['ytube_link'] = $this->request->getPost("ytube_link");


        $modall->update($ytubeID, $data);

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


    public function deleteYoutube()
    {

        $db = \Config\Database::connect();

        $ytube_id = $this->request->getPost();

        $query = 'UPDATE `tbl_youtube` SET `flag`= 0 WHERE `ytube_id` = ?';
        $updateData = $db->query($query, [$ytube_id]);

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
