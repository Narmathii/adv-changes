<?php
namespace App\Controllers\admin;

require 'vendor/autoload.php';
use App\Models\admin\RproductModal;
use App\Models\admin\ProdConfigModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class RproductController extends BaseController
{

    public function productList()
    {
        $db = \Config\Database::connect();
        $res['menu'] = $db->query("SELECT `r_menu_id`, `r_menu` FROM `tbl_riding_menu` WHERE `flag` =1")->getResultArray();
        // $res['submenu'] = $db->query('SELECT `r_sub_id`, `r_sub_menu` FROM `tbl_riding_submenu` WHERE `flag` =1')->getResultArray();
        $res['colour'] = $db->query('SELECT * FROM `tbl_color` WHERE `flag` = 1')->getResultArray();
        $res['searchbrand'] = $db->query('SELECT `brand_master_id`,`brand_name` FROM `brand_master` WHERE `flag`=1 ORDER BY brand_name ASC')->getResultArray();

        $query = "";

        $session = \Config\Services::session();
        if ($session->get('login_sts') == "") {
            return redirect()->to('admin');
        } else {
            return view('admin/ridingProducts', $res);
        }


    }



    public function getOfferprice()
    {
        $db = \Config\Database::connect();

        $searchBrandID = $this->request->getPost('search_brand');
        $query = "SELECT `offer_percentage`  FROM `brand_master` WHERE flag = 1 AND `brand_master_id` = ?";
        $getOfferPrice = $db->query($query, [$searchBrandID])->getRow();

        $result = $getOfferPrice->offer_percentage;

        if ($result != '') {
            $res['code'] = 200;
            $res['msg'] = 'success';
            $res['offer'] = $result;
        } else {
            $res['code'] = 400;
            $res['msg'] = 'failure';
            $res['offer'] = '';
        }

        echo json_encode($res);

    }
    // *************************** [Insert] *************************************************************************

    public function insertProductList()
    {
        $validation = \Config\Services::validation();
        $modal = new RproductModal;
        $configg = new ProdConfigModel;
        $db = \Config\Database::connect();
        $data = $this->request->getPost();


        $data['tbl_name'] = "tbl_rproduct_list";


        $validation->setRules([
            'product_img' => 'uploaded[product_img]|is_image[product_img]|mime_in[product_img,image/jpg,image/jpeg,image/png]',
        ]);


        $productImg = $this->request->getFile('product_img');

        if (!$validation->withRequest($this->request)->run()) {
            $res = $validation->getErrors();
            $result['code'] = 400;
            $result['status'] = 'Failure';
            $result['msg'] = 'Allowed Files : jpeg,jpg and png !!!';
            echo json_encode($result);

        } else {

            if ($this->request->getFile('product_img') && $this->request->getFile('product_img')->isValid()) {
                $productImg = $this->request->getFile('product_img');
                $prodname = $productImg->getRandomName();
                $prodname = str_replace(" ", "_", $prodname);
                $filePath = "uploads/ProductImg/";
                $productImg->move($filePath, $prodname);
                $data['product_img'] = $filePath . $prodname;
            }

            if ($this->request->getFile('img_1') != "" && $this->request->getFile('img_1')->isValid()) {
                $Img1 = $this->request->getFile('img_1');
                $img1 = $Img1->getRandomName();
                $img1 = str_replace(" ", "_", $img1);
                $filePath1 = "uploads/Img1/";
                $Img1->move($filePath1, $img1);
                $data['img_1'] = $filePath1 . $img1;
            }

            if ($this->request->getFile('img_2') != "" && $this->request->getFile('img_2')->isValid()) {
                $Img2 = $this->request->getFile('img_2');
                $img2 = $Img2->getRandomName();
                $img2 = str_replace(" ", "_", $img2);
                $filePath2 = "uploads/Img2/";
                $Img2->move($filePath2, $img2);
                $data['img_2'] = $filePath2 . $img2;
            }

            if ($this->request->getFile('img_3') != "" && $this->request->getFile('img_3')->isValid()) {
                $Img3 = $this->request->getFile('img_3');
                $img3 = $Img3->getRandomName();
                $img3 = str_replace(" ", "_", $img3);
                $filePath3 = "uploads/Img3/";
                $Img3->move($filePath3, $img3);
                $data['img_3'] = $filePath3 . $img3;
            }

            if ($this->request->getFile('img_4') != "" && $this->request->getFile('img_4')->isValid()) {
                $Img4 = $this->request->getFile('img_4');
                $img4 = $Img4->getRandomName();
                $img4 = str_replace(" ", "_", $img4);
                $filePath4 = "uploads/Img3/";
                $Img4->move($filePath4, $img4);
                $data['img_4'] = $filePath4 . $img4;
            }

            if ($this->request->getFile('img_5') != "" && $this->request->getFile('img_5')->isValid()) {
                $Img5 = $this->request->getFile('img_5');
                $img5 = $Img5->getRandomName();
                $img5 = str_replace(" ", "_", $img5);
                $filePath5 = "uploads/";
                $Img5->move($filePath5, $img5);
                $data['img_5'] = $filePath5 . $img5;
            }


            if ($this->request->getFile('img_6') != '' && $this->request->getFile('img_6')->isValid()) {
                $Img6 = $this->request->getFile('img_6');
                $img6 = $Img6->getRandomName();
                $img6 = str_replace(" ", "_", $img6);
                $filePath6 = "uploads/";

                $Img6->move($filePath6, $img6);

                $data['img_6'] = $filePath6 . $img6;
            }
            if ($this->request->getFile('img_7') != '' && $this->request->getFile('img_7')->isValid()) {
                $Img7 = $this->request->getFile('img_7');
                $img7 = $Img7->getRandomName();
                $img7 = str_replace(" ", "_", $img7);
                $filePath7 = "uploads/";

                $Img7->move($filePath7, $img7);

                $data['img_7'] = $filePath7 . $img7;
            }
            if ($this->request->getFile('img_8') != '' && $this->request->getFile('img_8')->isValid()) {
                $Img8 = $this->request->getFile('img_8');
                $img8 = $Img8->getRandomName();
                $img8 = str_replace(" ", "_", $img8);
                $filePath8 = "uploads/";

                $Img8->move($filePath8, $img8);

                $data['img_8'] = $filePath8 . $img8;
            }
            if ($this->request->getFile('img_9') != '' && $this->request->getFile('img_9')->isValid()) {
                $Img9 = $this->request->getFile('img_9');
                $img9 = $Img9->getRandomName();
                $img9 = str_replace(" ", "_", $img9);
                $filePath9 = "uploads/";

                $Img9->move($filePath9, $img9);

                $data['img_9'] = $filePath9 . $img9;
            }
            if ($this->request->getFile('img_10') != '' && $this->request->getFile('img_10')->isValid()) {
                $Img10 = $this->request->getFile('img_10');
                $img10 = $Img10->getRandomName();
                $img10 = str_replace(" ", "_", $img10);
                $filePath10 = "uploads/";

                $Img10->move($filePath10, $img10);

                $data['img_10'] = $filePath10 . $img10;

            }


            $insertData = $modal->insert($data);
            $affectedRows1 = $db->affectedRows();

            $stockSts = $this->request->getPost('soldout_status');
            // $colour = $this->request->getPost('colour');
            $size = $this->request->getPost('size');
            $prodID = $modal->insertID();
            $tblName = "tbl_rproduct_list";


            if ($affectedRows1) {
                $data2 = [
                    'prod_id' => $prodID,
                    'tbl_name' => $tblName,
                    'size' => json_encode($size),
                    'soldout_status' => json_encode($stockSts),
                ];

                $query = "SELECT * FROM `tbl_configuration` WHERE `flag` = 1 AND `prod_id` = ? AND tbl_name = ?";
                $oldData = $db->query($query, [$prodID, $tblName])->getResultArray();


                if (count($oldData) > 0) {

                    $updateQuery = "UPDATE tbl_configuration SET tbl_name = ?,size = ?, soldout_status = ? WHERE prod_id = ? AND tbl_name = ? WHERE prod_id = ? AND tbl_name = ?";
                    $updateData = $db->query($updateQuery, [$tblName, $data2['size'], $data2['soldout_status'], $prodID, $tblName]);
                    $affectedRows2 = $db->affectedRows();

                } else {

                    $insertConfig = $configg->insert($data2);
                    $affectedRows2 = $db->affectedRows();
                }


            }

            if ($affectedRows1 || $affectedRows2) {
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
    }

    public function getProductList()
    {
        $db = \Config\Database::connect();


        $q1 = 'SELECT
    a.r_menu,
    b.*,
    c.r_sub_menu
    FROM
    tbl_riding_menu AS a
INNER JOIN tbl_rproduct_list AS b
ON
    a.r_menu_id = b.r_menu_id
INNER JOIN tbl_riding_submenu AS c
ON
    c.r_sub_id = b.r_sub_id
    WHERE
    b.flag = 1
ORDER BY
    r_menu ASC;';


        $prodData = $db->query($q1)->getResultArray();
        for ($i = 0; $i < count($prodData); $i++) {
            $table_name = $prodData[$i]['tbl_name'];


            $prodID = $prodData[$i]['prod_id'];

            $q2 = 'SELECT DISTINCT
                prod_id AS configid, 
                config_id,  
                size, 
                soldout_status,
                config_img1,
                config_img2,
                config_img3,
                config_img4 
                FROM tbl_configuration 
                WHERE prod_id = ? 
                AND tbl_name = ?';

            $getConfigRes = $db->query($q2, [$prodID, $table_name])->getResultArray();

            if (empty($getConfigRes)) {
                // If configuration is empty, set default values
                $getConfigRes[] = [
                    'configid' => '',
                    'config_id' => '',
                    'size' => '',
                    'soldout_status' => '',
                    'config_img1' => '',
                    'config_img2' => '',
                    'config_img3' => '',
                    'config_img4' => '',
                ];
            }

            // Merge the first configuration record with the product data
            $prodData[$i] = array_merge($prodData[$i], $getConfigRes[0]);
        }



        echo json_encode($prodData);
    }


    // *************************** [update] *************************************************************************


    public function updateProductList()
    {
        $db = \Config\Database::connect();
        $configg = new ProdConfigModel;
        $data = $this->request->getPost();


        $prodId = $this->request->getPost('prod_id');
        $configId = $this->request->getPost('config_id');
        $tblName = "tbl_rproduct_list";

        ini_set('memory_limit', '1024M');

        // product Images and image1 - image 10
        $query = "SELECT product_img,img_1,img_2,img_3,img_4,img_5,img_6,img_7,img_8,img_9,img_10 FROM `tbl_rproduct_list` WHERE `flag` = 1 AND `prod_id` = ? ";
        $oldproductImages = $db->query($query, [$prodId])->getResultArray();

        $old_productImg = $oldproductImages[0]['product_img'];
        $old_img_1 = $oldproductImages[0]['img_1'];
        $old_img_2 = $oldproductImages[0]['img_2'];
        $old_img_3 = $oldproductImages[0]['img_3'];
        $old_img_4 = $oldproductImages[0]['img_4'];
        $old_img_5 = $oldproductImages[0]['img_5'];
        $old_img_6 = $oldproductImages[0]['img_6'];
        $old_img_7 = $oldproductImages[0]['img_7'];
        $old_img_8 = $oldproductImages[0]['img_8'];
        $old_img_9 = $oldproductImages[0]['img_9'];
        $old_img_10 = $oldproductImages[0]['img_10'];


        $productImage = "";
        $newProdImage = $this->request->getFile('product_img');
        if ($newProdImage->getName() == '') {
            $productImage = $old_productImg;
        } else {
            if ($newProdImage->isValid() && !$newProdImage->hasMoved()) {
                $prodnamee = $newProdImage->getName();
                $prodname = str_replace(" ", "_", $prodnamee);
                $filePath = "uploads/ProductImg/";
                $newProdImage->move($filePath, $prodname);
                $productImage = $filePath . $prodname;
            } else {
                $productImage = $old_productImg;
            }
        }

        $Image1 = "";
        $new_img_1 = $this->request->getFile('img_1');
        if ($new_img_1->getName() == '') {
            $Image1 = $old_img_1;
        } else {
            if ($new_img_1->isValid() && !$new_img_1->hasMoved()) {
                $image1_name = $new_img_1->getName();
                $image1 = str_replace(" ", "_", $image1_name);
                $filePath = "uploads/Img1/";
                $new_img_1->move($filePath, $image1);
                $Image1 = $filePath . $image1;
            } else {
                $Image1 = $old_img_1;
            }
        }

        $Image2 = "";
        $new_img_2 = $this->request->getFile('img_2');

        if ($new_img_2->getName() == '') {
            $Image2 = $old_img_2;


        } else {
            if ($new_img_2->isValid() && !$new_img_2->hasMoved()) {
                $image2_name = $new_img_2->getName();
                $image2 = str_replace(" ", "_", $image2_name);

                $filePath = "uploads/Img2/";
                $new_img_2->move($filePath, $image2);


                $Image2 = $filePath . $image2;

            } else {
                $Image2 = $old_img_2;
            }
        }


        $Image3 = "";
        $new_img_3 = $this->request->getFile('img_3');
        if ($new_img_3->getName() == '') {
            $Image3 = $old_img_3;
        } else {
            if ($new_img_3->isValid() && !$new_img_3->hasMoved()) {
                $image3_name = $new_img_3->getName();
                $image3 = str_replace(" ", "_", $image3_name);
                $filePath = "uploads/Img3/";
                $new_img_3->move($filePath, $image3);
                $Image3 = $filePath . $image3;
            } else {
                $Image3 = $old_img_3;
            }
        }

        $Image4 = "";
        $new_img_4 = $this->request->getFile('img_4');
        if ($new_img_4->getName() == '') {
            $Image4 = $old_img_4;
        } else {
            if ($new_img_4->isValid() && !$new_img_4->hasMoved()) {
                $image4_name = $new_img_4->getName();
                $image4 = str_replace(" ", "_", $image4_name);
                $filePath = "uploads/Img4/";
                $new_img_4->move($filePath, $image4);
                $Image4 = $filePath . $image4;
            } else {
                $Image4 = $old_img_4;
            }
        }


        $Image5 = "";
        $new_img_5 = $this->request->getFile('img_5');
        if ($new_img_5->getName() == '') {
            $Image5 = $old_img_5;
        } else {
            if ($new_img_5->isValid() && !$new_img_5->hasMoved()) {
                $image5_name = $new_img_5->getName();
                $image5 = str_replace(" ", "_", $image5_name);
                $filePath = "uploads/";
                $new_img_5->move($filePath, $image5);
                $Image5 = $filePath . $image5;
            } else {
                $Image5 = $old_img_5;
            }
        }

        $Image6 = "";
        $new_img_6 = $this->request->getFile('img_6');
        if ($new_img_6->getName() == '') {
            $Image6 = $old_img_6;
        } else {
            if ($new_img_6->isValid() && !$new_img_6->hasMoved()) {
                $image6_name = $new_img_6->getName();
                $image6 = str_replace(" ", "_", $image6_name);
                $filePath = "uploads/";
                $new_img_6->move($filePath, $image6);
                $Image6 = $filePath . $image6;
            } else {
                $Image6 = $old_img_6;
            }
        }



        $Image7 = "";
        $new_img_7 = $this->request->getFile('img_7');
        if ($new_img_7->getName() == '') {
            $Image7 = $old_img_7;
        } else {
            if ($new_img_7->isValid() && !$new_img_7->hasMoved()) {
                $image7_name = $new_img_7->getName();
                $image7 = str_replace(" ", "_", $image7_name);
                $filePath = "uploads/";
                $new_img_7->move($filePath, $image7);
                $Image7 = $filePath . $image7;
            } else {
                $Image7 = $old_img_7;
            }
        }

        $Image8 = "";
        $new_img_8 = $this->request->getFile('img_8');
        if ($new_img_8->getName() == '') {
            $Image8 = $old_img_8;
        } else {
            if ($new_img_8->isValid() && !$new_img_8->hasMoved()) {
                $image8_name = $new_img_8->getName();
                $image8 = str_replace(" ", "_", $image8_name);
                $filePath = "uploads/";
                $new_img_8->move($filePath, $image8);
                $Image8 = $filePath . $image8;
            } else {
                $Image8 = $old_img_8;
            }
        }


        $Image9 = "";
        $new_img_9 = $this->request->getFile('img_9');
        if ($new_img_9->getName() == '') {
            $Image9 = $old_img_9;
        } else {
            if ($new_img_9->isValid() && !$new_img_9->hasMoved()) {
                $image9_name = $new_img_9->getName();
                $image9 = str_replace(" ", "_", $image9_name);
                $filePath = "uploads/";
                $new_img_9->move($filePath, $image9);
                $Image9 = $filePath . $image9;
            } else {
                $Image9 = $old_img_9;
            }
        }

        $Image10 = " ";
        $new_img_10 = $this->request->getFile('img_10');
        if ($new_img_10->getName() == '') {
            $Image10 = $old_img_10;
        } else {
            if ($new_img_10->isValid() && !$new_img_10->hasMoved()) {
                $image10_name = $new_img_10->getName();
                $image10 = str_replace(" ", "_", $image10_name);
                $filePath = "uploads/";
                $new_img_10->move($filePath, $image10);
                $Image10 = $filePath . $image10;
            } else {
                $Image10 = $old_img_10;
            }
        }

        $data = [
            'r_menu_id' => $this->request->getPost('r_menu_id'),
            'r_sub_id' => $this->request->getPost('r_sub_id'),
            'billing_name' => $this->request->getPost('billing_name'),
            'product_name' => $this->request->getPost('product_name'),
            'product_price' => $this->request->getPost('product_price'),
            'offer_price' => $this->request->getPost('offer_price'),
            'offer_details' => $this->request->getPost('offer_details'),
            'arrival_status' => $this->request->getPost('arrival_status'),
            'stock_status' => $this->request->getPost('stock_status'),
            'redirect_url' => $this->request->getPost('redirect_url'),
            'offer_type' => $this->request->getPost('offer_type'),
            'product_img' => $productImage,
            'img_1' => $Image1,
            'img_2' => $Image2,
            'img_3' => $Image3,
            'img_4' => $Image4,
            'img_5' => $Image5,
            'img_6' => $Image6,
            'img_7' => $Image7,
            'img_8' => $Image8,
            'img_9' => $Image9,
            'img_10' => $Image10,
            'prod_desc' => $this->request->getPost('prod_desc'),
            'hot_sale' => $this->request->getPost('hot_sale'),
            'tbl_name' => 'tbl_rproduct_list',
            'search_brand' => $this->request->getPost('search_brand'),
            'weight' => $this->request->getPost('weight'),
            'weight_units' => $this->request->getPost('offer_type'),
            'quantity' => $this->request->getPost('quantity'),
            'specifications' => $this->request->getPost('specifications'),
            'drop_shipping' => $this->request->getPost('drop_shipping'),
        ];


        $db->query("SET @source = 'appteq'");
        $modal = new RproductModal;
        $updateRes = $modal->update($prodId, $data);

        $affectedRows1 = $db->affectedRows();

        // CONFIGURATION  IMAGES
        $newconfig_img1 = $this->request->getFileMultiple('config_img1');
        $newconfig_img2 = $this->request->getFileMultiple('config_img2');
        $newconfig_img3 = $this->request->getFileMultiple('config_img3');
        $newconfig_img4 = $this->request->getFileMultiple('config_img4');

        $query = "SELECT * FROM `tbl_configuration` WHERE `flag` = 1 AND `prod_id` = ? AND config_id = ? AND tbl_name = ?";
        $oldData = $db->query($query, [$prodId, $configId, $tblName])->getResultArray();


        $oldImages1 = json_decode($oldData[0]['config_img2']);
        $oldImages2 = json_decode($oldData[0]['config_img2']);
        $oldImages3 = json_decode($oldData[0]['config_img3']);
        $oldImages4 = json_decode($oldData[0]['config_img4']);


        $confiImgArray1 = [];
        $confiImgArray2 = [];
        $confiImgArray3 = [];
        $confiImgArray4 = [];

        $uploadDir = "uploads/";

        if ($newconfig_img1 == "") {
            $confiImgArray1[] = "";
        } else {
            for ($i = 0; $i < count($newconfig_img1); $i++) {
                if ($newconfig_img1[$i]->getName() == "") {
                    $confiImgArray1[] = $oldImages1[$i];
                } else {
                    if ($newconfig_img1[$i]->isValid() && !$newconfig_img1[$i]->hasMoved()) {
                        $newFileName = $newconfig_img1[$i]->getName();
                        $newconfig_img1[$i]->move($uploadDir, $newFileName);
                        $confiImgArray1[] = $uploadDir . $newFileName;
                    } else {
                        $confiImgArray1[] = $oldImages1[$i];
                    }
                }
            }
        }

        if ($newconfig_img2 == "") {
            $confiImgArray2[] = "";
        } else {
            for ($i = 0; $i < count($newconfig_img2); $i++) {
                if ($newconfig_img2[$i]->getName() == "") {
                    $confiImgArray2[] = $oldImages2[$i];
                } else {
                    if ($newconfig_img2[$i]->isValid() && !$newconfig_img2[$i]->hasMoved()) {
                        $newFileName = $newconfig_img2[$i]->getName();
                        $newconfig_img2[$i]->move($uploadDir, $newFileName);
                        $confiImgArray2[] = $uploadDir . $newFileName;
                    } else {
                        $confiImgArray2[] = $oldImages2[$i];
                    }
                }
            }
        }


        if ($newconfig_img3 == "") {
            $confiImgArray3[] = "";
        } else {
            for ($i = 0; $i < count($newconfig_img3); $i++) {
                if ($newconfig_img3[$i]->getName() == "") {
                    $confiImgArray3[] = $oldImages3[$i];
                } else {
                    if ($newconfig_img3[$i]->isValid() && !$newconfig_img3[$i]->hasMoved()) {
                        $newFileName = $newconfig_img3[$i]->getName();
                        $newconfig_img3[$i]->move($uploadDir, $newFileName);
                        $confiImgArray3[] = $uploadDir . $newFileName;
                    } else {
                        $confiImgArray3[] = $oldImages3[$i];
                    }
                }
            }
        }



        if ($newconfig_img4 == "") {
            $confiImgArray4[] = "";
        } else {
            for ($i = 0; $i < count($newconfig_img4); $i++) {
                if ($newconfig_img4[$i]->getName() == "") {
                    $confiImgArray4[] = $oldImages4[$i];
                } else {
                    if ($newconfig_img4[$i]->isValid() && !$newconfig_img4[$i]->hasMoved()) {
                        $newFileName = $newconfig_img4[$i]->getName();
                        $newconfig_img4[$i]->move($uploadDir, $newFileName);
                        $confiImgArray4[] = $uploadDir . $newFileName;
                    } else {
                        $confiImgArray4[] = $oldImages4[$i];
                    }
                }
            }

        }

        // data 2
        $stockSts = $this->request->getPost('soldout_status');
        $size = $this->request->getPost('size');
        $prodID = $prodId;
        $tblName = "tbl_rproduct_list";



        $data2 = [
            'prod_id' => $prodID,
            'tbl_name' => $tblName,
            'size' => json_encode($size),
            'soldout_status' => json_encode($stockSts),
        ];

        $query = "SELECT * FROM `tbl_configuration` WHERE `flag` = 1 AND `prod_id` = ? AND tbl_name = ? AND config_id = ?";
        $oldData = $db->query($query, [$prodID, $tblName, $configId])->getResultArray();


        if (count($oldData) > 0) {

            $updateQuery = "UPDATE tbl_configuration SET tbl_name = ?, size = ?, soldout_status = ? WHERE prod_id = ? AND  config_id = ? AND tbl_name = ?";
            $updateData = $db->query($updateQuery, [$tblName, $data2['size'], $data2['soldout_status'], $prodID, $configId, $tblName]);
            $affectedRows2 = $db->affectedRows();

        } else {

            $insertConfig = $configg->insert($data2);
            $affectedRows2 = $db->affectedRows();
        }

        if ($affectedRows1 || $affectedRows2) {
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


    public function getSubmenu()
    {
        $db = \Config\Database::connect();
        $menuId = $this->request->getPost('r_menu_id');

        $query = 'SELECT `r_sub_id`, `r_sub_menu` FROM `tbl_riding_submenu` WHERE `r_menu_id` =?';
        $getModal = $db->query($query, [$menuId])->getResultArray();

        echo json_encode($getModal);
    }


    // *************************** [Delete] *************************************************************************

    public function deleteProductList()
    {
        $db = \Config\Database::connect();

        $prodId = $this->request->getPost('prod_id');


        $query = 'UPDATE `tbl_rproduct_list` SET `flag` = 0 WHERE `prod_id` =?';
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



    public function getConfigColor()
    {
        $db = \Config\Database::connect();

        $query = "SELECT color_id , color_name  FROM `tbl_color` WHERE `flag` = 1";
        $res = $db->query($query)->getResultArray();
        echo json_encode($res);
    }

    public function exportStock()
    {
        ini_set('memory_limit', '1024M');

        $db = \Config\Database::connect();
        $query = "SELECT 
            `product_name`,
            `offer_price`,
            CASE 
                WHEN `offer_type` = 0 THEN 'Percentage'
                WHEN `offer_type` = 1 THEN 'Flat discount'
                WHEN `offer_type` = 2 THEN 'None'
                ELSE 'Other'
            END AS `offer_type_label`,
            `offer_details`,
            `quantity`,
            `weight`
        FROM 
            `tbl_rproduct_list`
        WHERE 
            `flag` = 1
        AND 
            `quantity` <= 0";

        // Query the stock details
        $stockDetails = $db->query($query)->getResultArray();

        // Create a new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $filename = 'Riding_stocks.xlsx';

        // Set headers for the columns
        $sheet->setCellValue('A1', 'Product Name');
        $sheet->setCellValue('B1', 'Product Price');
        $sheet->setCellValue('C1', 'Offer Type');
        $sheet->setCellValue('D1', 'Offer Details');
        $sheet->setCellValue('E1', 'Weight');
        $sheet->setCellValue('F1', 'Quantity');

        /* set background */
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],

            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => '829B2F',
                ],
            ],
        ];

        /* Style headers */
        $sheet->getStyle('A1:F1')->applyFromArray($headerStyle);

        /*Column width */
        $sheet->getColumnDimension('A')->setWidth(50);
        $sheet->getColumnDimension('C')->setWidth(40);

        // Populate the rows
        $row = 2;
        foreach ($stockDetails as $stock) {
            $sheet->setCellValue('A' . $row, $stock['product_name']);
            $sheet->setCellValue('B' . $row, $stock['offer_price']);
            $sheet->setCellValue('C' . $row, $stock['offer_type_label']);
            $sheet->setCellValue('D' . $row, $stock['offer_details']);
            $sheet->setCellValue('E' . $row, $stock['weight']);
            $sheet->setCellValue('F' . $row, $stock['quantity']);
            $row++;
        }

        // Write the file directly to the output stream
        $writer = new Xlsx($spreadsheet);

        // Set headers to force download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        // Save to PHP output
        $writer->save('php://output');
        exit();
    }


}