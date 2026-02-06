<?php
namespace App\Controllers\admin;

use App\Models\admin\AddProductModel;
use App\Models\admin\ProdConfigModel;

class ProductController extends BaseController
{

    public function addProducts()
    {
        $db = \Config\Database::connect();

        $res['brand_name'] = $db->query('SELECT `brand_id`,`brand_name` FROM `tbl_brand_master` WHERE `flag` = 1;')->getResultArray();
        $res['modal_name'] = $db->query('SELECT `modal_id`,`modal_name` FROM `tbl_modal_master` WHERE `flag`=1 ;')->getResultArray();
        $res['colour'] = $db->query('SELECT * FROM `tbl_color` WHERE `flag` = 1')->getResultArray();
        $res['searchbrand'] = $db->query('SELECT `brand_master_id`,`brand_name` FROM `brand_master` WHERE `flag`=1 ORDER BY brand_name ASC')->getResultArray();


        $session = \Config\Services::session();

        if ($session->get('login_sts') == "") {
            return redirect()->to('admin');
        } else {
            return view('admin/AddProducts', $res);
        }


    }

    // *************************** [Insert] *************************************************************************


    public function insertProducts()
    {
        $validation = \Config\Services::validation();
        $modal = new AddProductModel;
        $configg = new ProdConfigModel;
        $db = \Config\Database::connect();
        $data = $this->request->getPost();
        $data['tbl_name'] = "tbl_products";


        // $config_img1 = $this->request->getFileMultiple('config_img1');
        // $config_img2 = $this->request->getFileMultiple('config_img2');
        // $config_img3 = $this->request->getFileMultiple('config_img3');
        // $config_img4 = $this->request->getFileMultiple('config_img4');


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
            $result['msg'] = 'Allowed Files : jpeg,jpg and png !!!';
            echo json_encode($result);
        } else {

            $Img5 = $this->request->getFile('img_5');
            $Img6 = $this->request->getFile('img_6');
            $Img7 = $this->request->getFile('img_7');
            $Img8 = $this->request->getFile('img_8');
            $Img9 = $this->request->getFile('img_9');
            $Img10 = $this->request->getFile('img_10');


            $productImg->move('./uploads/ProductImg/');
            $Img1->move('./uploads/Img1/');
            $Img2->move('./uploads/Img2/');
            $Img3->move('./uploads/Img3/');
            $Img4->move('./uploads/Img4/');

            if ($Img5 && $Img5->isValid() && !$Img5->hasMoved()) {
                $Img5->move('./uploads/');
            }
            if ($Img6 && $Img6->isValid() && !$Img6->hasMoved()) {
                $Img6->move('./uploads');
            }
            if ($Img7 && $Img7->isValid() && !$Img7->hasMoved()) {
                $Img7->move('./uploads');
            }
            if ($Img8 && $Img8->isValid() && !$Img8->hasMoved()) {
                $Img8->move('./uploads');
            }
            if ($Img9 && $Img9->isValid() && !$Img9->hasMoved()) {
                $Img9->move('./uploads');
            }
            if ($Img10 && $Img10->isValid() && !$Img10->hasMoved()) {
                $Img10->move('./uploads');
            }


            $file_path1 = '/uploads/ProductImg/';
            $file_path2 = '/uploads/Img1/';
            $file_path3 = '/uploads/Img2/';
            $file_path4 = '/uploads/Img3/';
            $file_path5 = '/uploads/Img4/';
            $file_path = '/uploads';

            $Prodname = $productImg->getName();
            $img_1 = $Img1->getName();
            $img_2 = $Img2->getName();
            $img_3 = $Img3->getName();
            $img_4 = $Img4->getName();
            $img_5 = $Img5 ? $Img5->getName() : " ";
            $img_6 = $Img6 ? $Img6->getName() : " ";
            $img_7 = $Img7 ? $Img7->getName() : " ";
            $img_8 = $Img8 ? $Img8->getName() : " ";
            $img_9 = $Img9 ? $Img9->getName() : " ";
            $img_10 = $Img10 ? $Img10->getName() : " ";

            $data['product_img'] = $file_path1 . $Prodname;
            $data['img_1'] = $file_path2 . $img_1;
            $data['img_2'] = $file_path3 . $img_2;
            $data['img_3'] = $file_path4 . $img_3;
            $data['img_4'] = $file_path5 . $img_4;
            $data['img_5'] = $img_5 ? $file_path . $img_5 : " ";
            $data['img_6'] = $img_6 ? $file_path . $img_6 : " ";
            $data['img_7'] = $img_7 ? $file_path . $img_7 : " ";
            $data['img_8'] = $img_8 ? $file_path . $img_8 : " ";
            $data['img_9'] = $img_9 ? $file_path . $img_9 : " ";
            $data['img_10'] = $img_10 ? $file_path . $img_10 : " ";


            $insertData = $modal->insert($data);

            // $confiImgArray1 = [];
            // foreach ($config_img1 as $file) {
            //     if ($file->isValid()) {
            //         $uploadDir = "uploads/";
            //         $allowedTypes = 'gif|jpg|png|jpeg';


            //         $file->move($uploadDir, $file->getName());
            //         $confiImgArray1[] = $uploadDir . $file->getName();
            //     }
            // }

            // $confiImgArray2 = [];
            // foreach ($config_img2 as $file) {
            //     if ($file->isValid()) {
            //         $uploadDir = "uploads/";
            //         $allowedTypes = 'gif|jpg|png|jpeg';


            //         $file->move($uploadDir, $file->getName());
            //         $confiImgArray2[] = $uploadDir . $file->getName();
            //     }
            // }

            // $confiImgArray3 = [];
            // foreach ($config_img3 as $file) {
            //     if ($file->isValid()) {
            //         $uploadDir = "uploads/";
            //         $allowedTypes = 'gif|jpg|png|jpeg';


            //         $file->move($uploadDir, $file->getName());
            //         $confiImgArray3[] = $uploadDir . $file->getName();
            //     }
            // }


            // $confiImgArray4 = [];
            // foreach ($config_img4 as $file) {
            //     if ($file->isValid()) {
            //         $uploadDir = "uploads/";
            //         $allowedTypes = 'gif|jpg|png|jpeg';


            //         $file->move($uploadDir, $file->getName());
            //         $confiImgArray4[] = $uploadDir . $file->getName();
            //     }
            // }


            // $stockSts = $this->request->getPost('soldout_status');
            // $colour = $this->request->getPost('colour');
            // $size = $this->request->getPost('size');
            // $prodID = $modal->insertID();
            // $tblName = "tbl_products";

            if ($insertData) {

                $affectedRows = $db->affectedRows();
                if ($affectedRows > 0) {
                    $result['code'] = 200;
                    $result['msg'] = 'Data Inserted Successfully';
                    $result['status'] = 'success';
                    echo json_encode($result);
                } else {
                    $result['code'] = 400;
                    $result['status'] = 'Failed';
                    $result['msg'] = 'Something went wrong';
                    echo json_encode($result);
                }
            }
        }
    }

    // *************************** [get ] *************************************************************************

    public function getProducts()
    {
        $db = \Config\Database::connect();
        $res = [];
        $query =
            'SELECT DISTINCT
                a.brand_name,
            
                b.*,
                c.modal_name,
                d.brand_name
            
            FROM 
                tbl_brand_master AS a 
            INNER JOIN 
                tbl_products AS b ON a.brand_id = b.brand_id
            INNER JOIN 
                tbl_modal_master AS c ON c.modal_id = b.modal_id
            LEFT JOIN 
                brand_master AS d ON d.brand_master_id = b.search_brand
            WHERE 
                b.flag = 1

            UNION ALL

            SELECT DISTINCT
                "All Brands" as brand_name,
            
                b.*,
                "All Model" as modal_name,
                d.brand_name
            FROM 
                tbl_products AS b
            LEFT JOIN 
            brand_master AS d ON d.brand_master_id = b.search_brand
            WHERE 
                b.flag = 1
                AND (b.brand_id = 0 OR b.modal_id = 0)';
        $res = $db->query($query)->getResultArray();

        echo json_encode($res);
    }

    // *************************** [update] *************************************************************************

    public function updateProducts()
    {
        $db = \Config\Database::connect();
        $configg = new ProdConfigModel;

        $data = $this->request->getPost();
        $prodId = $this->request->getPost('prod_id');
        $configId = $this->request->getPost('config_id');
        $data['tbl_name'] = "tbl_products";



        // $newconfig_img1 = $this->request->getFileMultiple('config_img1');
        // $newconfig_img2 = $this->request->getFileMultiple('config_img2');
        // $newconfig_img3 = $this->request->getFileMultiple('config_img3');
        // $newconfig_img4 = $this->request->getFileMultiple('config_img4');


        ini_set('memory_limit', '1024M');

        $newconfig_img1 = $this->request->getFileMultiple('config_img1');
        $newconfig_img2 = $this->request->getFileMultiple('config_img2');
        $newconfig_img3 = $this->request->getFileMultiple('config_img3');
        $newconfig_img4 = $this->request->getFileMultiple('config_img4');

        $query = "SELECT * FROM `tbl_prod_config` WHERE `flag` = 1 AND `prod_id` = ? AND config_id = ?";
        $oldData = $db->query($query, [$prodId, $configId])->getResultArray();

        $oldImages1 = explode('|', $oldData[0]['config_img1']);
        $oldImages2 = explode('|', $oldData[0]['config_img2']);
        $oldImages3 = explode('|', $oldData[0]['config_img3']);
        $oldImages4 = explode('|', $oldData[0]['config_img4']);

        $confiImgArray1 = [];
        $confiImgArray2 = [];
        $confiImgArray3 = [];
        $confiImgArray4 = [];

        $uploadDir = "uploads/";

        // for ($i = 0; $i < count($newconfig_img1); $i++) {
        //     if ($newconfig_img1[$i]->getName() == "") {
        //         $confiImgArray1[] = $oldImages1[$i];
        //     } else {
        //         if ($newconfig_img1[$i]->isValid() && !$newconfig_img1[$i]->hasMoved()) {
        //             $newFileName = $newconfig_img1[$i]->getRandomName();
        //             $newconfig_img1[$i]->move($uploadDir, $newFileName);
        //             $confiImgArray1[] = $uploadDir . $newFileName;
        //         } else {
        //             $confiImgArray1[] = $oldImages1[$i];
        //         }
        //     }
        // }

        // for ($i = 0; $i < count($newconfig_img2); $i++) {
        //     if ($newconfig_img2[$i]->getName() == "") {
        //         $confiImgArray2[] = $oldImages2[$i];
        //     } else {
        //         if ($newconfig_img2[$i]->isValid() && !$newconfig_img2[$i]->hasMoved()) {
        //             $newFileName = $newconfig_img2[$i]->getRandomName();
        //             $newconfig_img2[$i]->move($uploadDir, $newFileName);
        //             $confiImgArray2[] = $uploadDir . $newFileName;
        //         } else {
        //             $confiImgArray2[] = $oldImages2[$i];
        //         }
        //     }
        // }

        // for ($i = 0; $i < count($newconfig_img3); $i++) {
        //     if ($newconfig_img3[$i]->getName() == "") {
        //         $confiImgArray3[] = $oldImages3[$i];
        //     } else {
        //         if ($newconfig_img3[$i]->isValid() && !$newconfig_img3[$i]->hasMoved()) {
        //             $newFileName = $newconfig_img3[$i]->getRandomName();
        //             $newconfig_img3[$i]->move($uploadDir, $newFileName);
        //             $confiImgArray3[] = $uploadDir . $newFileName;
        //         } else {
        //             $confiImgArray3[] = $oldImages3[$i];
        //         }
        //     }
        // }

        // for ($i = 0; $i < count($newconfig_img4); $i++) {
        //     if ($newconfig_img4[$i]->getName() == "") {
        //         $confiImgArray4[] = $oldImages4[$i];
        //     } else {
        //         if ($newconfig_img4[$i]->isValid() && !$newconfig_img4[$i]->hasMoved()) {
        //             $newFileName = $newconfig_img4[$i]->getRandomName();
        //             $newconfig_img4[$i]->move($uploadDir, $newFileName);
        //             $confiImgArray4[] = $uploadDir . $newFileName;
        //         } else {
        //             $confiImgArray4[] = $oldImages4[$i];
        //         }
        //     }
        // }

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


        if ($this->request->getFile('img_5') != '') {
            $Img5 = $this->request->getFile('img_5');
            $img5 = $Img5->getName();
            $img5 = str_replace(" ", "_", $img5);
            $filePath = "uploads/";

            $Img5->move($filePath, $img5);

            $data['img_5'] = $filePath . $img5;
        }


        if ($this->request->getFile('img_6') != '') {
            $Img6 = $this->request->getFile('img_6');
            $img6 = $Img6->getName();
            $img6 = str_replace(" ", "_", $img6);
            $filePath = "uploads/";

            $Img6->move($filePath, $img6);

            $data['img_6'] = $filePath . $img6;
        }


        if ($this->request->getFile('img_7') != '') {
            $Img7 = $this->request->getFile('img_7');
            $img7 = $Img7->getName();
            $img7 = str_replace(" ", "_", $img7);
            $filePath = "uploads/";
            $Img7->move($filePath, $img7);
            $data['img_7'] = $filePath . $img7;
        }


        if ($this->request->getFile('img_8') != '') {
            $Img8 = $this->request->getFile('img_8');
            $img8 = $Img8->getName();
            $img8 = str_replace(" ", "_", $img8);
            $filePath = "uploads/";
            $Img8->move($filePath, $img8);
            $data['img_8'] = $filePath . $img8;
        }


        if ($this->request->getFile('img_9') != '') {
            $Img9 = $this->request->getFile('img_9');
            $img9 = $Img9->getName();
            $img9 = str_replace(" ", "_", $img9);
            $filePath = "uploads/";
            $Img9->move($filePath, $img9);
            $data['img_9'] = $filePath . $img9;
        }


        if ($this->request->getFile('img_10') != '') {
            $Img10 = $this->request->getFile('img_10');
            $img10 = $Img10->getName();
            $img10 = str_replace(" ", "_", $img10);
            $filePath4 = "uploads/";

            $Img10->move($filePath4, $img10);
            $data['img_10'] = $filePath4 . $img10;
        }

        $modal = new AddProductModel;
        $updateRes = $modal->update($prodId, $data);
        $affectedRows1 = $db->affectedRows();

        if ($affectedRows1) {
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

    // *************************** [Delete] *************************************************************************

    public function deleteProducts()
    {

        $db = \Config\Database::connect();

        $prodId = $this->request->getPost('prod_id');

        $query = 'update`tbl_products` SET `flag` = 0 WHERE `prod_id` = ?';
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



    public function getModalName()
    {

        $db = \Config\Database::connect();
        $brandId = $this->request->getPost('brand_id');

        $allModels = [];


        for ($i = 0; $i < count($brandId); $i++) {
            $currentBrand = $brandId[$i];

            if ($currentBrand != 0) {

                $query = 'SELECT `modal_id`,`modal_name` FROM tbl_modal_master WHERE `brand_id` = ? AND flag=1';
                $getModal = $db->query($query, $currentBrand)->getResultArray();

                if (!empty($getModal)) {
                    $allModels = array_merge($allModels, $getModal);
                }
            } else if ($currentBrand == 0) {

                $allModels[] = [
                    'modal_id' => 0,
                    'modal_name' => 'All models'
                ];
            }
        }
        echo json_encode($allModels);
    }

    public function insertConfig()
    {
        $data = $this->request->getPost();

        $configg = new ProdConfigModel;
        $db = \Config\Database::connect();

        $stockSts = $this->request->getPost('soldout_status');
        $colour = $this->request->getPost('colour');
        $size = $this->request->getPost('size');
        $prodID = $this->request->getPost('prod_id');
        $tblName = $this->request->getPost('tbl_name');


        $finalColor = implode('|', $colour);
        $finalSize = implode('|', $size);
        $finalStock = implode('|', $stockSts);

        $data = [
            'prod_id' => $prodID,
            'tbl_name' => $tblName,
            'colour' => $finalColor,
            'size' => $finalSize,
            'soldout_status' => $finalStock
        ];

        $query = "SELECT * FROM `tbl_prod_config` WHERE `flag` = 1 AND `prod_id` = ?";
        $oldData = $db->query($query, [$prodID])->getResultArray();

        if (count($oldData) > 0) {
            $updateQuery = "UPDATE tbl_prod_config SET prod_id = ?, tbl_name = ?, colour = ?, size = ?, soldout_status = ? WHERE prod_id = ?";
            $updateData = $db->query($updateQuery, [$prodID, $tblName, $finalColor, $finalSize, $finalStock, $prodID]);

        } else {
            $insertConfig = $configg->insert($data);
        }

        $affectedRows = $db->affectedRows();
        if ($affectedRows > 0) {
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

    public function getConfigColor()
    {
        $db = \Config\Database::connect();

        $query = "SELECT color_id,color_name FROM `tbl_color` WHERE `flag` = 1";
        $res = $db->query($query)->getResultArray();
        echo json_encode($res);
    }

}


