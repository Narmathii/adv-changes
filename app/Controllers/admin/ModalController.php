<?php

namespace App\Controllers\admin;

use App\Models\admin\ModalList;

class ModalController extends BaseController
{

    public function modalList()
    {
        $db = \Config\Database::connect();

        $query = "SELECT * FROM `tbl_brand_master` WHERE `flag` =1 AND `is_active` = 1 ORDER BY brand_name ASC;";
        $getData['brand_list'] = $db->query($query)->getResult();

        $session = \Config\Services::session();

        if ($session->get('login_sts') == "") {
            return redirect()->to('admin');
        } else {
            return view('admin/modelList', $getData);
        }


    }

    public function insertModalList()
    {

        $db = \Config\Database::connect();
        $modal = new ModalList;

        $validation = \Config\Services::validation();
        $validation->setRules([
            'modal_img' => 'uploaded[modal_img]|max_size[modal_img,1024]|is_image[modal_img]'
        ]);


        if (!$validation->withRequest($this->request)->run()) {
            $res = $validation->getErrors();
            $result['code'] = 400;
            $result['status'] = 'Failed';
            $result['msg'] = $res;
            echo json_encode($result);
        } else {
            $modalImg = $this->request->getFile('modal_img');
            $modalImg->move('./uploads/modalImg/');
            $file_path = '/uploads/modalImg/';
            $name = $modalImg->getName();

            $modalName = $this->request->getPost('modal_name');
            $brand_id = $this->request->getPost('brand_id');


            $data = [
                'brand_id' => $brand_id,
                'modal_name' => $modalName,
                'modal_img' => $file_path . $name
            ];



            // echo "<pre>";print_r($data);exit;
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


    }

    public function getModalDetails()
    {
        $db = \Config\Database::connect();
        $query = 'SELECT
                    a.brand_name,
                    b.*
                FROM
                    tbl_brand_master AS a
                INNER JOIN tbl_modal_master AS b
                ON
                    a.brand_id = b.brand_id
                WHERE
                    b.flag = 1
                ORDER BY
                    `brand_name` ASC';
        $res = $db->query($query)->getResultArray();
        echo json_encode($res);
    }

    public function updateModalDetails()
    {
        $db = \Config\Database::connect();
        $modal = new ModalList;

        $validation = service('validation');

        $validation->setRules([
            'modal_img' => 'uploaded[modal_img]|mime_in[modal_img,image/png,image/jpg,image/jpeg]',
        ]);
        $modalID = $this->request->getPost('modal_id');
        $brandID = $this->request->getPost('brand_id');
        $ModalName = $this->request->getPost('modal_name');

        $data = [
            'brand_id' => $brandID,
            'modal_name' => $ModalName,

        ];
        if ($this->request->getFile('modal_img') != '') {
            $image_file = $this->request->getFile('modal_img');
            $newImageFile = $image_file->getRandomName();
            $prodname = str_replace(" ", "_", $newImageFile);
            $filepath = '/uploads/modalImg/';

            $image_file->move('./uploads/modalImg/', $newImageFile);

            $data['modal_img'] = $filepath . $prodname;
        }

        $modal->update($modalID, $data);
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


    public function deleteModalDetails()
    {

        $db = \Config\Database::connect();

        $modal_id = $this->request->getPost('modal_id');
        $query = 'UPDATE `tbl_modal_master` SET `flag`= 0 WHERE `modal_id` = ?';
        $updateData = $db->query($query, [$modal_id]);

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
