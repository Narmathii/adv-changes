<?php
namespace App\Controllers\admin;

use App\Models\admin\ComboModel;


class ComboProdController extends BaseController
{

    public function productList()
    {
        $db = \Config\Database::connect();
        $res['colour'] = $db->query('SELECT * FROM `tbl_color` WHERE `flag` = 1')->getResultArray();
        return view('admin/combo', $res);
    }


    public function insertProduct()
    {

        $validation = \Config\Services::validation();
        $modal = new ComboModel;
        $db = \Config\Database::connect();

        $validation->setRules([
            'product_img' => 'uploaded[product_img]|is_image[product_img]|mime_in[product_img,image/jpg,image/jpeg,image/png]',
            'img_1' => 'uploaded[img_1]|is_image[img_1]|mime_in[img_1,image/jpg,image/jpeg,image/png]',
            'img_2' => 'uploaded[img_2]|is_image[img_2]|mime_in[img_2,image/jpg,image/jpeg,image/png]',
            'img_3' => 'uploaded[img_3]|is_image[img_3]|mime_in[img_3,image/jpg,image/jpeg,image/png]',
            'img_4' => 'uploaded[img_4]|is_image[img_4]|mime_in[img_4,image/jpg,image/jpeg,image/png]',

        ]);


        $productImg = $this->request->getFile('product_img');
        $Img1 = $this->request->getFile('img_1');
        $Img2 = $this->request->getFile('img_2');
        $Img3 = $this->request->getFile('img_3');
        $Img4 = $this->request->getFile('img_4');

        if (!$validation->withRequest($this->request)->run()) {
            $res = $validation->getErrors();
            $result['code'] = 400;
            $result['status'] = 'Failure';
            $result['msg'] = 'Something Went Wrong!';
            echo json_encode($result);

        } else {

            $productImg->move('./uploads/ProductImg/');
            $Img1->move('./uploads/Img1/');
            $Img2->move('./uploads/Img2/');
            $Img3->move('./uploads/Img3/');
            $Img4->move('./uploads/Img4/');


            $file_path1 = '/uploads/ProductImg/';
            $file_path2 = '/uploads/Img1/';
            $file_path3 = '/uploads/Img2/';
            $file_path4 = '/uploads/Img3/';
            $file_path5 = '/uploads/Img4/';

            $Prodname = $productImg->getName();
            $img_1 = $Img1->getName();
            $img_2 = $Img2->getName();
            $img_3 = $Img3->getName();
            $img_4 = $Img4->getName();

            $data = $this->request->getPost();

            $data['product_img'] = $file_path1 . $Prodname;
            $data['img_1'] = $file_path2 . $img_1;
            $data['img_2'] = $file_path3 . $img_2;
            $data['img_3'] = $file_path4 . $img_3;
            $data['img_4'] = $file_path5 . $img_4;

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


    public function getproduct()
    {

        $db = \Config\Database::connect();

        $query =
            'SELECT a.color_name, a.color_id, b.*  FROM  tbl_color AS a 
            INNER join tbl_combo_product AS b ON a.color_id = b.colour 
            WHERE b.flag = 1;';
        $res = $db->query($query)->getResultArray();
        
        echo json_encode($res);
    }

    public function updateProduct()
    {

        $db = \Config\Database::connect();

        $prodId = $this->request->getPost('prod_id');
       
        $data = $this->request->getPost();
        

        if ($this->request->getFile('product_img') != '') {
            $productImg = $this->request->getFile('product_img');
            $prodname = $productImg->getName();
            $prodname = str_replace(" ", "_", $prodname);
            $filePath = "uploads/ProductImg/";

            $productImg->move($filePath, $prodname);

            $data['product_img'] = $filePath . $prodname;
        }

        if ($this->request->getFile('img_1') != '') {
            $Img1 = $this->request->getFile('img_1');
            $img1 = $Img1->getName();
            $img1 = str_replace(" ", "_", $img1);
            $filePath1 = "uploads/Img1/";

            $Img1->move($filePath1, $img1);

            $data['img_1'] = $filePath1 . $img1;
        }

        if ($this->request->getFile('img_2') != '') {
            $Img2 = $this->request->getFile('img_2');
            $img2 = $Img2->getName();
            $img2 = str_replace(" ", "_", $img2);
            $filePath2 = "uploads/Img2/";

            $Img2->move($filePath2, $img2);

            $data['img_2'] = $filePath2 . $img2;
        }
        if ($this->request->getFile('img_3') != '') {
            $Img3 = $this->request->getFile('img_3');
            $img3 = $Img3->getName();
            $img3 = str_replace(" ", "_", $img3);
            $filePath3 = "uploads/Img3/";

            $Img3->move($filePath3, $img3);

            $data['img_3'] = $filePath3 . $img3;
        }

        if ($this->request->getFile('img_4') != '') {
            $Img4 = $this->request->getFile('img_4');
            $img4 = $Img4->getName();
            $img4 = str_replace(" ", "_", $img4);
            $filePath4 = "uploads/Img3/";

            $Img4->move($filePath4, $img4);

            $data['img_4'] = $filePath4 . $img4;
        }

        $modal = new ComboModel;
        $updateRes = $modal->update($prodId, $data);
        $affectedRows = $db->affectedRows();



        if ($updateRes && $affectedRows) {
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



    public function deleteProduct()
    {

        $db = \Config\Database::connect();

        $prodId = $this->request->getPost('prod_id');


        $query = 'update`tbl_combo_product` SET `flag` = 0 WHERE `prod_id` = ?';
        $res = $db->query($query, $prodId);

        $affected_rows = $db->affectedRows();

        if ($affected_rows && $res) {
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


