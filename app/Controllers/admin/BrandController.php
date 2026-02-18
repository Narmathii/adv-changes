<?php

namespace App\Controllers\admin;

use App\Models\admin\BrandModel;

class BrandController extends BaseController
{

    public function brandList()
    {

        $session = \Config\Services::session();

        if ($session->get('login_sts') == "") {
            return redirect()->to('admin');
        } else {
            return view('admin/brandList');
        }

    }

    public function insertBrandList()
    {
        $model = new BrandModel();
        $validation = \Config\Services::validation();
        $db = \Config\Database::connect();

        $validation->setRules([
            'brand_img' => 'uploaded[brand_img]|max_size[brand_img,1024]|is_image[brand_img]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            $res = $validation->getErrors();
            $result['code'] = 400;
            $result['status'] = 'Failed';
            $result['msg'] = $res;
            echo json_encode($result);

        } else {
            $brandImg = $this->request->getFile('brand_img');
            $brandImg->move('./uploads/brandImg/');
            $file_path = '/uploads/brandImg/';
            $name = $brandImg->getName();


            $data = [
                'brand_name' => $this->request->getPost('brand_name'),
                'brand_img' => $file_path . $name
            ];

            $model->insert($data);
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


    // get Data
    public function getBrandData()
    {
        $db = \Config\Database::connect();
        $query = 'SELECT * FROM `tbl_brand_master` WHERE `flag` =1 ORDER BY `brand_name` ASC';
        $res = $db->query($query)->getResult();

        echo json_encode($res);
    }

    public function updateBrandList()
    {

        $db = \Config\Database::connect();

        $brandID = $this->request->getPost('brand_id');
        $brandName = $this->request->getPost('brand_name');

        $data = [
            'brand_name' => $brandName,
        ];

        $validation = service('validation');

        $validation->setRules([
            'brand_img' => 'uploaded[brand_img]|mime_in[brand_img,image/png,image/jpg,image/jpeg]',
        ]);

        if ($this->request->getFile('brand_img' != '')) {
            $image_file = $this->request->getFile('brand_img');
            $newImageFile = $image_file->getRandomName();
            $prodname = str_replace(" ", "_", $newImageFile);
            $filepath = '/uploads/brandImg/';

            $image_file->move('./uploads/brandImg/', $newImageFile);


            $data['brand_img'] = $filepath . $prodname;
        }


        $brandModel = new BrandModel();
        $brandModel->update($brandID, $data);
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



    public function deleteBrandList()
    {
        $brand_id = $this->request->getPost('brand_id');

        $db = \Config\Database::connect();

        $query = 'UPDATE `tbl_brand_master` SET `flag`= 0 WHERE `brand_id` = ?';
        $updateData = $db->query($query, [$brand_id]);

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
