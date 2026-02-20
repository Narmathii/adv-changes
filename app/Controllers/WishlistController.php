<?php
namespace App\Controllers;

use App\Models\WishlistModel;

class WishlistController extends BaseController
{

    public function addwishlist()
    {
        $wishModel = new WishlistModel();
        $this->session = \Config\Services::session();
        $db = \Config\Database::connect();
        $userID = session()->get('user_id');

        $data = $this->request->getPost();


        $prodID = $this->request->getPost('prod_id');
        $tblName = $this->request->getPost('tbl_name');
        $quantity = $this->request->getPost('quantity');
        $size = $this->request->getPost('size');
        $postedSizeStock = $this->request->getPost('size_stock');

        $sizeData = $size != '' ? $size : 0;
        $resolvedSizeStock = 0;


        if ($size != '') {
            $sizequery = "SELECT `size`, `soldout_status` FROM `tbl_configuration` WHERE flag = 1 AND `prod_id` = ? AND `tbl_name` = ?;";
            $getSize = $db->query($sizequery, [$prodID, $tblName])->getRow();

            if ($getSize) {
                $sizeArray = json_decode($getSize->size, true);
                $stockArray = json_decode($getSize->soldout_status, true);

                if (is_array($sizeArray) && is_array($stockArray)) {
                    $sizeArray = array_map('strval', $sizeArray);
                    $matchedIndex = array_search((string) $size, $sizeArray, true);
                    if ($matchedIndex !== false && isset($stockArray[$matchedIndex])) {
                        $resolvedSizeStock = (int) $stockArray[$matchedIndex];
                    }
                }
            }

            if ($resolvedSizeStock <= 0 && is_numeric($postedSizeStock)) {
                $resolvedSizeStock = (int) $postedSizeStock;
            }

        } else {
            $resolvedSizeStock = 0;
        }


        $data = [
            'prod_id' => $prodID,
            'tbl_name' => $tblName,
            'user_id' => $userID,
            'size' => $sizeData,
            'size_stock' => $resolvedSizeStock
        ];




        $query = "SELECT * FROM `tbl_wishlist` WHERE `prod_id` = ? AND `tbl_name` = ? AND  `user_id` = ? AND `flag` = 1";
        $getData = $db->query($query, [$prodID, $tblName, $userID])->getResultArray();

        if (count($getData) > 0) {
            $res["code"] = "400";
            $res["msg"] = "Product Already in wishlist";

        } else {

            $insertData = $wishModel->insert($data);
            $affectedRow = $db->affectedRows();
            if ($insertData && $affectedRow > 0) {
                $res["code"] = "200";
                $res["msg"] = "Product added to your wishlist";

            }
        }

        echo json_encode($res);

    }

    public function deletewishlist()
    {
        $db = \Config\Database::connect();

        $prodID = $this->request->getPost('prod_id');
        // $csrf = $this->request->getHeader('X-CSRF-TOKEN')->getValue();

        $query = "UPDATE tbl_wishlist SET `flag` = 0 WHERE `prod_id` = ?";
        $dltData = $db->query($query, $prodID);

        $affectedRows = $db->affectedRows();

        if ($dltData && $affectedRows) {
            $result['code'] = 200;
            $result['msg'] = 'Product Deleted!!';
            $result['status'] = 'success';
            $result['csrf'] = csrf_hash();

            echo json_encode($result);
        } else {
            $result['code'] = 400;
            $result['msg'] = 'Something Wrong';
            $result['status'] = 'failure';
            $result['csrf'] = csrf_hash();
            echo json_encode($result);
        }
    }

}
