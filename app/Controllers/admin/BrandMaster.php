<?php

namespace App\Controllers\admin;

use App\Models\admin\BrandMasterModel;

class BrandMaster extends BaseController
{

    public function brands()
    {
        $session = \Config\Services::session();

        if ($session->get('login_sts') == "") {
            return redirect()->to('admin');
        } else {
            return view('admin/brands');
        }
    }



    public function insertBrandData()
    {
        $model = new BrandMasterModel();
        $validation = \Config\Services::validation();
        $db = \Config\Database::connect();

        $getData = $this->request->getPost();

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
                'brand_img' => $file_path . $name,
                'offer_percentage' => $this->request->getPost('offer_percentage'),
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
        $query = 'SELECT * FROM `brand_master` WHERE `flag` =1 ORDER BY brand_name ASC';
        $res = $db->query($query)->getResult();



        echo json_encode($res);
    }

    public function updateBrandData()
    {
        $db = \Config\Database::connect();

        $brandID = $this->request->getPost('brand_master_id');
        $brandName = $this->request->getPost('brand_name');
        $offer = $this->request->getPost('offer_percentage');


        $data = $this->request->getPost();



        // Update Price based on offerprice in brandmaster start

        $tableArray = ['tbl_accessories_list', 'tbl_rproduct_list', 'tbl_helmet_products', 'tbl_luggagee_products', 'tbl_camping_products'];
        $brandArray = [];
        for ($i = 0; $i < count($tableArray); $i++) {
            $tblName = $tableArray[$i];
            $query = "SELECT DISTINCT `prod_id` ,`tbl_name`,`product_price`  FROM $tblName  WHERE `search_brand` = ? OR `search_brand` = ? AND flag =1";
            $getResult = $db->query($query, [$brandName, $brandID])->getResultArray();
            $brandArray = [...$brandArray, ...$getResult];
        }



        for ($j = 0; $j < count($brandArray); $j++) {
            $prodID = $brandArray[$j]['prod_id'];
            $tblName = $brandArray[$j]['tbl_name'];
            $OriginalAmt = $brandArray[$j]['product_price'];

            $discountAmt = $offer / 100;
            $offerAmount = $OriginalAmt * (1 - $discountAmt);

            // Format the offer amount to two decimal places
            $offerAmt = number_format($offerAmount, 2, '.', '');
            $offerType = 0;

            // Update the offer price and offer type in the product table
            $updateqry = "UPDATE $tblName SET offer_price = ?, offer_type = ?, offer_details = ? WHERE prod_id = ?";
            $updateData = $db->query($updateqry, [$offerAmt, $offerType, $offer, $prodID]);

            $affectedRows1 = $db->affectedRows();
        }

        // end

        $data = [
            'brand_name' => $brandName,
            'offer_percentage' => $offer,
        ];

        if ($this->request->getFile('brand_img')) {
            if ($this->request->getFile('brand_img')->isValid() && !$this->request->getFile('brand_img')->hasMoved()) {
                $image_file = $this->request->getFile('brand_img');
                $newImageFile = $image_file->getName();


                $prodname = str_replace(" ", "_", $newImageFile);
                $filepath = '/uploads/brandImg/';


                $image_file->move('.' . $filepath, $prodname);


                $data['brand_img'] = $filepath . $prodname;
            }
        }


        $BrandMasterModel = new BrandMasterModel();

        $BrandMasterModel->update($brandID, $data);
        $affectedRows = $db->affectedRows();

        // Check if the update was successful
        if ($affectedRows === 1) {
            $result['code'] = 200;
            $result['msg'] = 'Data updates Successfully';
            $result['status'] = 'success';
        } else {
            $result['code'] = 400;
            $result['msg'] = 'Data not updated';
            $result['status'] = 'failure';
        }

        // Return the result as JSON
        echo json_encode($result);
    }




    public function deleteBrandData()
    {
        $brand_id = $this->request->getPost('brand_master_id');

        $db = \Config\Database::connect();

        $query = 'UPDATE `brand_master` SET `flag`= 0 WHERE `brand_master_id` = ?';
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