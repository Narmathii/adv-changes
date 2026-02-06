<?php

namespace App\Controllers\admin;

use App\Models\admin\AccessListModal;
use App\Models\admin\ProdConfigModel;
use App\Models\admin\CommonAccessModel;
use PhpParser\Node\Stmt\Else_;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class AccessListController extends BaseController
{
    public function accessList()
    {
        $db = \Config\Database::connect();
        $res['access_name'] = $db->query('SELECT `access_id`,`access_title` FROM `tbl_access_master` WHERE `flag` =1 ORDER BY access_title ASC;')->getResultArray();
        $res['colour'] = $db->query('SELECT * FROM `tbl_color` WHERE `flag` = 1')->getResultArray();
        $res['searchbrand'] = $db->query('SELECT `brand_master_id`,`brand_name` FROM `brand_master` WHERE `flag`=1 ORDER BY brand_name ASC')->getResultArray();
        $res['brand_name'] = $db->query('SELECT `brand_id`,`brand_name` FROM `tbl_brand_master` WHERE `flag` = 1 ORDER BY `brand_name` ASC ;')->getResultArray();
        $res['modal_name'] = $db->query('SELECT `modal_id`,`modal_name` FROM `tbl_modal_master` WHERE `flag`=1 ;')->getResultArray();


        $session = \Config\Services::session();

        if ($session->get('login_sts') == "") {
            return redirect()->to('admin');
        } else {
            return view('admin/accessoriesList', $res);
        }

    }

    // *************************** [Insert] *************************************************************************

    public function insertProducts()
    {
        $validation = \Config\Services::validation();
        $modal = new AccessListModal;
        $commonModel = new CommonAccessModel;
        $configg = new ProdConfigModel;
        $db = \Config\Database::connect();

        $data = $this->request->getpost();


        $data['tbl_name'] = "tbl_accessories_list";


        $validation->setRules([
            'product_img' => 'uploaded[product_img]|is_image[product_img]|mime_in[product_img,image/jpg,image/jpeg,image/png]',
        ]);

        $productImg = $this->request->getFile('product_img');

        if (!$validation->withRequest($this->request)->run()) {
            $res = $validation->getErrors();
            $result['code'] = 400;
            $result['status'] = 'Failure';
            $result['msg'] = 'Allowed Files : jpeg,jpg and png!!!';
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
            $affectedRows = $db->affectedRows();



            if ($affectedRows) {

                $lastInsertedID = $modal->insertID();

                $modalName = $this->request->getPost('modal_name');
                $brandName = $this->request->getPost('brand_name');


                if ($modalName != "") {
                    $modalID = implode(',', $modalName);
                }
                if ($brandName != "") {
                    $brandID = implode(',', $brandName);
                }
                $oldData = $db->query("SELECT * FROM `tbl_common_accessories` WHERE `prod_id` =  $lastInsertedID AND `flag` = 1")->getResultArray();

                $dataCount = count($oldData);

                if ($dataCount > 0) {
                    $updateqry = "UPDATE tbl_common_accessories SET prod_id = ?,brand_name = ?,modal_name = ? WHERE prod_id = ? ";
                    $update = $db->query($updateqry, [$lastInsertedID, $brandID, $modalID, $lastInsertedID]);
                    $affectedRows = $db->affectedRows();
                    if ($affectedRows == 1) {
                        $result['code'] = 200;
                        $result['msg'] = 'Data inserted Successfully';
                        $result['status'] = 'success';
                    }

                } else {
                    $commondetail = [
                        'prod_id' => $lastInsertedID,
                        'brand_name' => $brandID,
                        'modal_name' => $modalID
                    ];

                    $Insert = $commonModel->insert($commondetail);
                    $affectedRows = $db->affectedRows();

                    if ($affectedRows == 1) {
                        $result['code'] = 200;
                        $result['msg'] = 'Data Inserted Successfully';
                        $result['status'] = 'success';
                    }

                }


                echo json_encode($result);
            } else {
                $result['code'] = 400;
                $result['status'] = 'Failed';
                $result['msg'] = 'Something went wrong';

                echo json_encode($result);
            }
        }

    }


    public function getProductList()
    {
        $db = \Config\Database::connect();
        $query =
            'SELECT
                    a.*,
                    b.access_title,
                    c.sub_access_name,
                    d.brand_name,
                    e.brand_name AS commonbrand_id,
                    e.modal_name AS commonmodal_id
                FROM
                    tbl_accessories_list AS a
                INNER JOIN tbl_access_master AS b
                ON
                    a.access_id = b.access_id
                INNER JOIN tbl_subaccess_master AS c
                ON
                    c.sub_access_id = a.sub_access_id
                LEFT JOIN brand_master AS d
                ON
                    a.search_brand = d.brand_master_id
                LEFT JOIN tbl_common_accessories AS e
                ON  
                    e.prod_id = a.prod_id
                WHERE
                    a.flag = 1';

        $res = $db->query($query)->getResultArray();



        // Loop to process modal names
        for ($i = 0; $i < count($res); $i++) {
            if ($res[$i]['commonmodal_id'] != "") {
                $modal = explode(',', $res[$i]['commonmodal_id']);

                $modalNames = [];
                for ($j = 0; $j < count($modal); $j++) {
                    if ($modal[$j] == 0) {
                        $modalNames[] = 'All Models';
                    } else if ($modal[$j] == "") {
                        $modalNames[] = '';
                    } else {
                        $modalID = $modal[$j];
                        $modalQuery = "SELECT modal_name FROM tbl_modal_master WHERE flag = 1 AND modal_id = ?";
                        $modalResult = $db->query($modalQuery, [$modalID])->getRowArray();

                        if ($modalResult) {
                            $modalNames[] = $modalResult['modal_name'];
                        }
                    }

                }
                $res[$i]['common_model'] = $modalNames;
            } else {
                $res[$i]['common_model'] = "";
            }

        }



        // Loop to process brand names
        for ($i = 0; $i < count($res); $i++) {
            if ($res[$i]['commonbrand_id'] != "") {
                $brand = explode(',', $res[$i]['commonbrand_id']);
                $brandNames = [];
                for ($j = 0; $j < count($brand); $j++) {
                    if ($brand[$j] == 0) {
                        $brandNames[] = 'All Brands';
                    } else if ($brand[$j] == '') {
                        $brandNames[] = '';
                    } else {
                        $brandID = $brand[$j];
                        $brandQuery = "SELECT `brand_name` FROM `tbl_brand_master` WHERE `flag` = 1 AND `brand_id` = ?";
                        $brandResult = $db->query($brandQuery, [$brandID])->getRowArray();

                        if ($brandResult) {
                            $brandNames[] = $brandResult['brand_name'];
                        }
                    }
                }
                $res[$i]['common_brands'] = $brandNames;
            } else {
                $res[$i]['common_brands'] = "";
            }

        }


        echo json_encode($res);
    }

    // *************************** [update] *************************************************************************

    public function updateProductList()
    {
        $db = \Config\Database::connect();
        $configg = new ProdConfigModel;
        $commonModel = new CommonAccessModel;

        $data = $this->request->getPost();

        $accessId = $this->request->getPost('prod_id');
        $configId = $this->request->getPost('config_id');
        $brandName = $this->request->getPost('brand_name');
        $modalName = $this->request->getPost('modal_name');


        $modalID = implode(',', $modalName);
        $brandID = implode(',', $brandName);
        $data['tbl_name'] = "tbl_accessories_list";

        ini_set('memory_limit', '1024M');


        $query = "SELECT * FROM `tbl_prod_config` WHERE `flag` = 1 AND `prod_id` = ? AND config_id = ?";
        $oldData = $db->query($query, [$accessId, $configId])->getResultArray();


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

        $db->query("SET @source = 'appteq'");
        $accessmodal = new AccessListModal;

        $updateRes = $accessmodal->update($accessId, $data);
        $affectedRows1 = $db->affectedRows();



        if ($brandID != "" && $modalID != "null") {

            $oldDataQry = "SELECT * FROM `tbl_common_accessories` WHERE `prod_id` = ? AND `flag` = 1";
            $oldData = $db->query($oldDataQry, [$accessId])->getResultArray();
            $dataCount = count($oldData);

            if ($dataCount > 0) {
                $updateqry = "UPDATE tbl_common_accessories SET brand_name = ?, modal_name = ? WHERE prod_id = ?";
                $update = $db->query($updateqry, [$brandID, $modalID, $accessId]);
                $affectedRows = $db->affectedRows();

            } else {
                $commonData = [
                    'prod_id' => $accessId,
                    'brand_name' => $brandID,
                    'modal_name' => $modalID
                ];

                $insert = $commonModel->insert($commonData);
                $affectedRows = $db->affectedRows();
            }
        }


        if ($affectedRows1 == 1 || $affectedRows == 1) {
            $result['code'] = 200;
            $result['msg'] = 'Data updated Successfully';
            $result['status'] = 'success';
        } else {
            $result['code'] = 400;
            $result['status'] = 'Failed';
            $result['msg'] = 'Failed to update data';
        }

        echo json_encode($result);


    }
    // *************************** [Delete] *************************************************************************

    public function deleteProductList()
    {
        $db = \Config\Database::connect();

        $accessId = $this->request->getPost('prod_id');

        $query = 'UPDATE `tbl_accessories_list` SET `flag` = 0 WHERE `prod_id` =?';
        $dltres = $db->query($query, $accessId);

        $affected_rows = $db->affectedRows();

        if ($affected_rows) {
            $dltCommonData = "UPDATE  tbl_common_accessories  SET `flag` = 0 WHERE prod_id = ?";
            $res = $db->query($dltCommonData, [$accessId]);
            $result['code'] = 200;
            $result['status'] = 'success';
            $result['message'] = 'Deleted Successfully';
        }


        if ($affected_rows && $dltres) {
            $result['code'] = 200;
            $result['status'] = 'success';
            $result['message'] = 'Deleted Successfully';

        } else {
            $result['code'] = 400;
            $result['status'] = 'Failure';
            $result['message'] = 'Something wrong';

        }
        echo json_encode($result);
    }

    public function getSubAccess()
    {
        $db = \Config\Database::connect();
        $acc_id = $this->request->getPost('access_id');
        $query = 'SELECT `sub_access_id`,`sub_access_name` FROM `tbl_subaccess_master` WHERE `access_id` = ?  AND `flag` =  1 ORDER BY sub_access_name ASC';

        $res = $db->query($query, [$acc_id])->getResultArray();

        echo json_encode($res);
    }

    public function exportOutofStockList()
    {
        ini_set('memory_limit', '1024M');

        $db = \Config\Database::connect();
        $query = "SELECT DISTINCT
    a.prod_id,a.product_name,a.billing_name,a.product_price,a.offer_price,a.offer_type,
    a.offer_details,a.redirect_url,a.arrival_status,a.stock_status,a.prod_desc,a.hot_sale,
    a.search_brand,a.weight,a.weight_units,a.quantity,a.specifications, a.tbl_name,
    CASE 
        WHEN `offer_type` = 0 THEN 'Percentage' 
        WHEN `offer_type` = 1 THEN 'Flat discount' 
        WHEN `offer_type` = 2 THEN 'None' 
        ELSE 'Other' 
    END AS `offer_type_label`, 
    b.access_title AS menu, 
    c.sub_access_name AS submenu,d.brand_name AS search_brand 
FROM
    tbl_accessories_list AS a 
    INNER JOIN tbl_access_master AS b ON a.access_id = b.access_id 
    INNER JOIN tbl_subaccess_master AS c ON a.sub_access_id = c.sub_access_id
    LEFT JOIN brand_master AS d ON a.search_brand = d.brand_master_id
WHERE
    a.`flag` = 1 AND a.`quantity` <= 0 AND b.`flag` = 1 AND c.flag = 1
    GROUP BY  a.prod_id 

UNION

SELECT DISTINCT
    a.prod_id,a.product_name,a.billing_name,a.product_price,a.offer_price,a.offer_type,
    a.offer_details,a.redirect_url,a.arrival_status,a.stock_status,a.prod_desc,a.hot_sale,
    a.search_brand,a.weight,a.weight_units,a.quantity,a.specifications, a.tbl_name,
    CASE 
        WHEN `offer_type` = 0 THEN 'Percentage' 
        WHEN `offer_type` = 1 THEN 'Flat discount' 
        WHEN `offer_type` = 2 THEN 'None' 
        ELSE 'Other' 
    END AS `offer_type_label`, 
    b.r_menu AS menu, 
    c.r_sub_menu AS submenu,d.brand_name AS search_brand 
FROM
    tbl_rproduct_list AS a 
    INNER JOIN tbl_riding_menu AS b ON a.r_menu_id = b.r_menu_id
    INNER JOIN tbl_riding_submenu AS c ON a.r_sub_id = c.r_sub_id
     LEFT JOIN brand_master AS d ON a.search_brand = d.brand_master_id
WHERE
    a.`flag` = 1 AND a.`quantity` <=0  AND b.`flag` = 1 AND c.flag = 1
  GROUP BY  a.prod_id 
UNION

SELECT DISTINCT
    a.prod_id,a.product_name,a.billing_name,a.product_price,a.offer_price,a.offer_type,
    a.offer_details,a.redirect_url,a.arrival_status,a.stock_status,a.prod_desc,a.hot_sale,
    a.search_brand,a.weight,a.weight_units,a.quantity,a.specifications, a.tbl_name,
    CASE 
        WHEN `offer_type` = 0 THEN 'Percentage' 
        WHEN `offer_type` = 1 THEN 'Flat discount' 
        WHEN `offer_type` = 2 THEN 'None' 
        ELSE 'Other' 
    END AS `offer_type_label`, 
    b.lug_menu AS menu, 
    c.lug_submenu AS submenu,d.brand_name AS search_brand 
FROM
    tbl_luggagee_products AS a
    INNER JOIN tbl_luggage_menu AS b ON a.lug_menu_id = b.lug_menu_id
    INNER JOIN tbl_luggage_submenu AS c ON c.lug_submenu_id = a.lug_submenu_id
     LEFT JOIN brand_master AS d ON a.search_brand = d.brand_master_id
WHERE
    a.`flag` = 1 AND a.`quantity` <=0   AND b.`flag` = 1 AND c.flag = 1
  GROUP BY  a.prod_id 
UNION

SELECT DISTINCT
    a.prod_id,a.product_name,a.billing_name,a.product_price,a.offer_price,a.offer_type,
    a.offer_details,a.redirect_url,a.arrival_status,a.stock_status,a.prod_desc,a.hot_sale,
    a.search_brand,a.weight,a.weight_units,a.quantity,a.specifications, a.tbl_name,
    CASE 
        WHEN `offer_type` = 0 THEN 'Percentage' 
        WHEN `offer_type` = 1 THEN 'Flat discount' 
        WHEN `offer_type` = 2 THEN 'None' 
        ELSE 'Other' 
    END AS `offer_type_label`, 
    b.h_menu AS menu, 
    c.h_submenu AS submenu,d.brand_name AS search_brand 
FROM
    tbl_helmet_products AS a 
    INNER JOIN tbl_helmet_menu AS b ON a.h_menu_id = b.h_menu_id
    INNER JOIN tbl_helmet_submenu AS c ON c.h_submenu_id = a.h_submenu_id
     LEFT JOIN brand_master AS d ON a.search_brand = d.brand_master_id
WHERE
    a.`flag` = 1 AND a.`quantity` <=  0  AND b.`flag` = 1 AND c.flag = 1
  GROUP BY  a.prod_id 
UNION

SELECT DISTINCT
    a.prod_id,a.product_name,a.billing_name,a.product_price,a.offer_price,a.offer_type,
    a.offer_details,a.redirect_url,a.arrival_status,a.stock_status,a.prod_desc,a.hot_sale,
    a.search_brand,a.weight,a.weight_units,a.quantity,a.specifications, a.tbl_name,
    CASE 
        WHEN `offer_type` = 0 THEN 'Percentage' 
        WHEN `offer_type` = 1 THEN 'Flat discount' 
        WHEN `offer_type` = 2 THEN 'None' 
        ELSE 'Other' 
    END AS `offer_type_label`, 
    b.camp_menu AS menu, 
    c.c_submenu AS submenu,d.brand_name AS search_brand  
FROM
    tbl_camping_products AS a 
    INNER JOIN tbl_camping_menu AS b ON a.camp_menu_id = b.camp_menu_id
    INNER JOIN tbl_camping_submenu AS c ON a.c_submenu_id = c.c_submenu_id 
    LEFT JOIN brand_master AS d ON a.search_brand = d.brand_master_id
WHERE
    a.`flag` = 1 AND a.`quantity` <= 0  AND b.`flag` = 1 AND c.flag = 1
GROUP BY a.prod_id
ORDER BY `product_name` ASC;
";

        // Query the stock details
        $stockDetails = $db->query($query)->getResultArray();

        // Create a new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $filename = 'OutofStockDetails.xlsx';

        // Set headers for the columns
        $sheet->setCellValue('A1', 'Product name');
        $sheet->setCellValue('B1', 'Menu');
        $sheet->setCellValue('C1', 'Sub Menu');
        $sheet->setCellValue('D1', 'Bill Name');
        $sheet->setCellValue('E1', 'Product Price');
        $sheet->setCellValue('F1', 'Offer Type');
        $sheet->setCellValue('G1', 'Offer Details');
        $sheet->setCellValue('H1', 'Offer Price');
        $sheet->setCellValue('I1', 'Inventory Status');
        $sheet->setCellValue('J1', 'Stock Status');
        $sheet->setCellValue('K1', 'Redirect URL');
        $sheet->setCellValue('L1', 'Quantity');
        $sheet->setCellValue('M1', 'Weight');
        $sheet->setCellValue('N1', 'Weight Unit');
        $sheet->setCellValue('O1', 'Description');
        $sheet->setCellValue('P1', 'Brands');
        $sheet->setCellValue('Q1', 'Specification');
        $sheet->setCellValue('R1', 'Hotsale');
        $sheet->setCellValue('S1', 'Size & Stock');


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
        $sheet->getStyle('A1:S1')->applyFromArray($headerStyle);
        $sheet->getStyle('L:L')->getFill()->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFF00'); // Yellow


        /*Column width */
        $sheet->getColumnDimension('A')->setWidth(50);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(40);

        $sheet->getColumnDimension('I')->setWidth(30);

        $sheet->getColumnDimension('J')->setWidth(30);

        $sheet->getColumnDimension('O')->setWidth(70);
        $sheet->getColumnDimension('P')->setWidth(30);
        $sheet->getColumnDimension('S')->setWidth(70);



        // Populate the rows
        $row = 2;
        foreach ($stockDetails as $stock) {
            $statusMap = [
                1 => 'New Arrivals',
                2 => 'Current',
                3 => 'Upcoming'
            ];

            $inventory = $statusMap[$stock['arrival_status']] ?? 'Unknown';

            $stockMap = [
                1 => 'Available',
                2 => 'Outof Stock',
                3 => 'Contact us to order'
            ];
            $stockStatus = $stockMap[$stock['stock_status']] ?? 'Unknown';

            $hotsale = $stock['hot_sale'] == 1 ? 'Yes' : 'No';

            $prod_id = $stock['prod_id'];
            $tbl_name = $stock['tbl_name'];

            $sizeqry = "SELECT * FROM `tbl_configuration`  WHERE `prod_id` = ? AND `tbl_name` = ? AND flag = 1";
            $sizeDetails = $db->query($sizeqry, [$prod_id, $tbl_name])->getRow();

            if ($sizeDetails) {
                $size = json_decode($sizeDetails->size);
                $size_stock = json_decode($sizeDetails->soldout_status);
            } else {
                $size = [];
                $size_stock = [];
            }


            $sizeStockFormatted = '';
            if (!empty($size) && !empty($size_stock)) {
                $formattedPairs = [];
                foreach ($size as $index => $s) {
                    $stockVal = $size_stock[$index] ?? '-';
                    $formattedPairs[] = "{$s} - {$stockVal}";
                }
                $sizeStockFormatted = implode(', ', $formattedPairs);
            } else {
                $sizeStockFormatted = '-';
            }


            $sheet->setCellValue('A' . $row, $stock['product_name']);
            $sheet->setCellValue('B' . $row, $stock['menu']);
            $sheet->setCellValue('C' . $row, $stock['submenu']);
            $sheet->setCellValue('D' . $row, $stock['billing_name']);
            $sheet->setCellValue('E' . $row, $stock['product_price']);
            $sheet->setCellValue('F' . $row, $stock['offer_type_label']);
            $sheet->setCellValue('G' . $row, $stock['offer_details']);
            $sheet->setCellValue('H' . $row, $stock['offer_price']);
            $sheet->setCellValue('I' . $row, $inventory);
            $sheet->setCellValue('J' . $row, $stockStatus);
            $sheet->setCellValue('K' . $row, $stock['redirect_url']);
            $sheet->setCellValue('L' . $row, $stock['quantity']);
            $sheet->setCellValue('M' . $row, $stock['weight']);
            $sheet->setCellValue('N' . $row, 'g');
            $sheet->setCellValue('O' . $row, $stock['prod_desc']);
            $sheet->setCellValue('P' . $row, $stock['search_brand']);
            $sheet->setCellValue('Q' . $row, $stock['specification']);
            $sheet->setCellValue('R' . $row, $hotsale);
            $sheet->setCellValue('S' . $row, $sizeStockFormatted);
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
    public function exportStockList()
    {
        ini_set('memory_limit', '1024M');

        $db = \Config\Database::connect();
        $query = "SELECT DISTINCT
    a.prod_id,a.product_name,a.billing_name,a.product_price,a.offer_price,a.offer_type,
    a.offer_details,a.redirect_url,a.arrival_status,a.stock_status,a.prod_desc,a.hot_sale,
    a.search_brand,a.weight,a.weight_units,a.quantity,a.specifications,a.tbl_name,
    CASE 
        WHEN `offer_type` = 0 THEN 'Percentage' 
        WHEN `offer_type` = 1 THEN 'Flat discount' 
        WHEN `offer_type` = 2 THEN 'None' 
        ELSE 'Other' 
    END AS `offer_type_label`, 
    b.access_title AS menu, 
    c.sub_access_name AS submenu,d.brand_name AS search_brand 
FROM
    tbl_accessories_list AS a 
    INNER JOIN tbl_access_master AS b ON a.access_id = b.access_id 
    INNER JOIN tbl_subaccess_master AS c ON a.sub_access_id = c.sub_access_id
     INNER JOIN brand_master AS d ON a.search_brand = d.brand_master_id
WHERE
    a.`flag` = 1 AND a.`quantity` > 0
    GROUP BY  a.prod_id 

UNION

SELECT DISTINCT
    a.prod_id,a.product_name,a.billing_name,a.product_price,a.offer_price,a.offer_type,
    a.offer_details,a.redirect_url,a.arrival_status,a.stock_status,a.prod_desc,a.hot_sale,
    a.search_brand,a.weight,a.weight_units,a.quantity,a.specifications,a.tbl_name,
    CASE 
        WHEN `offer_type` = 0 THEN 'Percentage' 
        WHEN `offer_type` = 1 THEN 'Flat discount' 
        WHEN `offer_type` = 2 THEN 'None' 
        ELSE 'Other' 
    END AS `offer_type_label`, 
    b.r_menu AS menu, 
    c.r_sub_menu AS submenu,d.brand_name AS search_brand 
FROM
    tbl_rproduct_list AS a 
    INNER JOIN tbl_riding_menu AS b ON a.r_menu_id = b.r_menu_id
    INNER JOIN tbl_riding_submenu AS c ON a.r_sub_id = c.r_sub_id
     INNER JOIN brand_master AS d ON a.search_brand = d.brand_master_id
WHERE
    a.`flag` = 1 AND a.`quantity` > 0
  GROUP BY  a.prod_id 
UNION

SELECT DISTINCT
    a.prod_id,a.product_name,a.billing_name,a.product_price,a.offer_price,a.offer_type,
    a.offer_details,a.redirect_url,a.arrival_status,a.stock_status,a.prod_desc,a.hot_sale,
    a.search_brand,a.weight,a.weight_units,a.quantity,a.specifications,a.tbl_name,
    CASE 
        WHEN `offer_type` = 0 THEN 'Percentage' 
        WHEN `offer_type` = 1 THEN 'Flat discount' 
        WHEN `offer_type` = 2 THEN 'None' 
        ELSE 'Other' 
    END AS `offer_type_label`, 
    b.lug_menu AS menu, 
    c.lug_submenu AS submenu,d.brand_name AS search_brand 
FROM
    tbl_luggagee_products AS a
    INNER JOIN tbl_luggage_menu AS b ON a.lug_menu_id = b.lug_menu_id
    INNER JOIN tbl_luggage_submenu AS c ON c.lug_submenu_id = a.lug_submenu_id
     INNER JOIN brand_master AS d ON a.search_brand = d.brand_master_id
WHERE
    a.`flag` = 1 AND a.`quantity` > 0
  GROUP BY  a.prod_id 
UNION

SELECT DISTINCT
    a.prod_id,a.product_name,a.billing_name,a.product_price,a.offer_price,a.offer_type,
    a.offer_details,a.redirect_url,a.arrival_status,a.stock_status,a.prod_desc,a.hot_sale,
    a.search_brand,a.weight,a.weight_units,a.quantity,a.specifications, a.tbl_name,
    CASE 
        WHEN `offer_type` = 0 THEN 'Percentage' 
        WHEN `offer_type` = 1 THEN 'Flat discount' 
        WHEN `offer_type` = 2 THEN 'None' 
        ELSE 'Other' 
    END AS `offer_type_label`, 
    b.h_menu AS menu, 
    c.h_submenu AS submenu,d.brand_name AS search_brand 
FROM
    tbl_helmet_products AS a 
    INNER JOIN tbl_helmet_menu AS b ON a.h_menu_id = b.h_menu_id
    INNER JOIN tbl_helmet_submenu AS c ON c.h_submenu_id = a.h_submenu_id
     INNER JOIN brand_master AS d ON a.search_brand = d.brand_master_id
WHERE
    a.`flag` = 1 AND a.`quantity` > 0
  GROUP BY  a.prod_id 
UNION

SELECT DISTINCT
    a.prod_id,a.product_name,a.billing_name,a.product_price,a.offer_price,a.offer_type,
    a.offer_details,a.redirect_url,a.arrival_status,a.stock_status,a.prod_desc,a.hot_sale,
    a.search_brand,a.weight,a.weight_units,a.quantity,a.specifications,a.tbl_name,
    CASE 
        WHEN `offer_type` = 0 THEN 'Percentage' 
        WHEN `offer_type` = 1 THEN 'Flat discount' 
        WHEN `offer_type` = 2 THEN 'None' 
        ELSE 'Other' 
    END AS `offer_type_label`, 
    b.camp_menu AS menu, 
    c.c_submenu AS submenu,d.brand_name AS search_brand 
FROM
    tbl_camping_products AS a 
    INNER JOIN tbl_camping_menu AS b ON a.camp_menu_id = b.camp_menu_id
    INNER JOIN tbl_camping_submenu AS c ON  a.c_submenu_id = c.c_submenu_id
     INNER JOIN brand_master AS d ON a.search_brand = d.brand_master_id
WHERE
    a.`flag` = 1 AND a.`quantity` > 0
GROUP BY a.prod_id
ORDER BY `product_name` ASC;
";

        // Query the stock details
        $stockDetails = $db->query($query)->getResultArray();





        // Create a new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $filename = 'Product_StockDetails.xlsx';

        // Set headers for the columns
        $sheet->setCellValue('A1', 'Product name');
        $sheet->setCellValue('B1', 'Menu');
        $sheet->setCellValue('C1', 'Sub Menu');
        $sheet->setCellValue('D1', 'Bill Name');
        $sheet->setCellValue('E1', 'Product Price');
        $sheet->setCellValue('F1', 'Offer Type');
        $sheet->setCellValue('G1', 'Offer Details');
        $sheet->setCellValue('H1', 'Offer Price');
        $sheet->setCellValue('I1', 'Inventory Status');
        $sheet->setCellValue('J1', 'Stock Status');
        $sheet->setCellValue('K1', 'Redirect URL');
        $sheet->setCellValue('L1', 'Quantity');
        $sheet->setCellValue('M1', 'Weight');
        $sheet->setCellValue('N1', 'Weight Unit');
        $sheet->setCellValue('O1', 'Description');
        $sheet->setCellValue('P1', 'Brands');
        $sheet->setCellValue('Q1', 'Specification');
        $sheet->setCellValue('R1', 'Hotsale');
        $sheet->setCellValue('S1', 'Size & Stock');


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
        $sheet->getStyle('A1:S1')->applyFromArray($headerStyle);
        $sheet->getStyle('L:L')->getFill()->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFF00'); // Yellow

        /*Column width */
        $sheet->getColumnDimension('A')->setWidth(50);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(40);

        $sheet->getColumnDimension('I')->setWidth(30);

        $sheet->getColumnDimension('J')->setWidth(30);

        $sheet->getColumnDimension('O')->setWidth(70);
        $sheet->getColumnDimension('P')->setWidth(30);
        $sheet->getColumnDimension('S')->setWidth(70);


        // Populate the rows
        $row = 2;
        foreach ($stockDetails as $stock) {
            $statusMap = [
                1 => 'New Arrivals',
                2 => 'Current',
                3 => 'Upcoming'
            ];

            $inventory = $statusMap[$stock['arrival_status']] ?? 'Unknown';

            $stockMap = [
                1 => 'Available',
                2 => 'Outof Stock',
                3 => 'Contact us to order'
            ];
            $stockStatus = $stockMap[$stock['stock_status']] ?? 'Unknown';

            $hotsale = $stock['hot_sale'] == 1 ? 'Yes' : 'No';

            $prod_id = $stock['prod_id'];
            $tbl_name = $stock['tbl_name'];

            $sizeqry = "SELECT * FROM `tbl_configuration`  WHERE `prod_id` = ? AND `tbl_name` = ? AND flag = 1";
            $sizeDetails = $db->query($sizeqry, [$prod_id, $tbl_name])->getRow();

            if ($sizeDetails) {
                $size = json_decode($sizeDetails->size);
                $size_stock = json_decode($sizeDetails->soldout_status);
            } else {
                $size = [];
                $size_stock = [];
            }


            $sizeStockFormatted = '';
            if (!empty($size) && !empty($size_stock)) {
                $formattedPairs = [];
                foreach ($size as $index => $s) {
                    $stockVal = $size_stock[$index] ?? '-';
                    $formattedPairs[] = "{$s} - {$stockVal}";
                }
                $sizeStockFormatted = implode(', ', $formattedPairs);
            } else {
                $sizeStockFormatted = '-';
            }

            $sheet->setCellValue('A' . $row, $stock['product_name']);
            $sheet->setCellValue('B' . $row, $stock['menu']);
            $sheet->setCellValue('C' . $row, $stock['submenu']);
            $sheet->setCellValue('D' . $row, $stock['billing_name']);
            $sheet->setCellValue('E' . $row, $stock['product_price']);
            $sheet->setCellValue('F' . $row, $stock['offer_type_label']);
            $sheet->setCellValue('G' . $row, $stock['offer_details']);
            $sheet->setCellValue('H' . $row, $stock['offer_price']);
            $sheet->setCellValue('I' . $row, $inventory);
            $sheet->setCellValue('J' . $row, $stockStatus);
            $sheet->setCellValue('K' . $row, $stock['redirect_url']);
            $sheet->setCellValue('L' . $row, $stock['quantity']);
            $sheet->setCellValue('M' . $row, $stock['weight']);
            $sheet->setCellValue('N' . $row, 'g');
            $sheet->setCellValue('O' . $row, $stock['prod_desc']);
            $sheet->setCellValue('P' . $row, $stock['search_brand']);
            $sheet->setCellValue('Q' . $row, $stock['specification']);
            $sheet->setCellValue('R' . $row, $hotsale);
            $sheet->setCellValue('S' . $row, $sizeStockFormatted);

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


    public function getShopBrands()
    {
        $db = \Config\Database::connect();
        $res = $db->query('SELECT `brand_id`,`brand_name` FROM `tbl_brand_master` WHERE `flag` = 1;')->getResultArray();
        echo json_encode($res);

    }

    public function getShopModals()
    {
        $db = \Config\Database::connect();
        $brands = $this->request->getPost('brand_id');

        $modalList = [];
        foreach ($brands as $brandID) {
            $query = "SELECT `modal_id`, `modal_name` FROM `tbl_modal_master` WHERE `flag`=1 AND `brand_id` = ?";
            $res = $db->query($query, [$brandID])->getResultArray();

            $modalList = array_merge($modalList, $res);
        }

        echo json_encode($modalList);


    }

}