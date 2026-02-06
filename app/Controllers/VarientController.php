<?php

namespace App\Controllers;



class VarientController extends BaseController
{
    public function getConfigDetails()
    {
        $db = \Config\Database::connect();
        $prodID = $this->request->getPost('prod_id');
        $tblName = $this->request->getPost('table_name');

        $query2 = "SELECT * FROM `tbl_configuration` WHERE prod_id = ? AND tbl_name = ? AND flag =1";
        $res["config"] = $db->query($query2, [$prodID, $tblName])->getResultArray();

        $sizequery = "SELECT `size_id`,`size` FROM tbl_size WHERE flag = 1";
        $sizeResult = $db->query($sizequery)->getResultArray();

        $selectedSize = json_decode($res["config"][0]['size']);

        $sizeMap = [];
        foreach ($sizeResult as $size) {
            $sizeMap[$size['size_id']] = $size['size'];
        }

        $mappedSizes = [];

        for ($i = 0; $i < count($selectedSize); $i++) {
            for ($j = 0; $j < count($selectedSize[$i]); $j++) {
                $sizeId = $selectedSize[$i][$j];
                if (isset($sizeMap[$sizeId])) {
                    $mappedSizes[$i][] = $sizeMap[$sizeId];
                }
            }
        }


        // $query3 = "SELECT `size_id`,`size` FROM `tbl_size` WHERE `flag` = 1";
        // $res['size'] = $db->query($query3)->getResultArray();

        $configImg1 = json_decode($res["config"][0]['config_img1']);
        $configImg2 = json_decode($res["config"][0]['config_img2']);
        $configImg3 = json_decode($res["config"][0]['config_img3']);
        $configImg4 = json_decode($res["config"][0]['config_img4']);
        $size = json_decode($res["config"][0]['size']);

        $configDetails = [
            'configImg1' => $configImg1,
            'configImg2' => $configImg2,
            'configImg3' => $configImg3,
            'configImg4' => $configImg4,
            'size_id' => $size,
            'size_name' => $mappedSizes
        ];
        echo json_encode($configDetails);
    }

    // public function getSizeMaster()
    // {
    //     $db = \Config\Database::connect();
    //     $query = "SELECT * FROM `tbl_size` WHERE `flag` = 1";

    //     $res['size'] = $db->query($query)->getResultArray();



    // }


    public function getVarients()
    {
        $db = \Config\Database::connect();
        $data = $this->request->getPost();
        $prodID = $this->request->getPost('prod_id');
        $tblName = $this->request->getPost('table_name');
        $colorID = $this->request->getPost('colorID');

        $query = "SELECT * FROM `tbl_configuration` WHERE `prod_id` = ? AND `tbl_name` = ?  AND `flag` = 1";
        $res = $db->query($query, [$prodID, $tblName])->getResultArray();


        $configImg1 = json_decode($res[0]['config_img1']);
        $configImg2 = json_decode($res[0]['config_img2']);
        $configImg3 = json_decode($res[0]['config_img3']);
        $configImg4 = json_decode($res[0]['config_img4']);
        $size = json_decode($res[0]['size']);
        $color = json_decode($res[0]['colour']);
        $stock = json_decode($res[0]['soldout_status']);



        $filtrSize = [];
        $img1 = [];
        $img2 = [];
        $img3 = [];
        $img4 = [];
        for ($i = 0; $i < count($color); $i++) {
            if ($color[$i] == $colorID && $stock[$i] != 0) {
                $filtrSize[] = $size[$i];
                $img1[] = $configImg1[$i];
                $img2[] = $configImg2[$i];
                $img3[] = $configImg3[$i];
                $img4[] = $configImg4[$i];
            }
        }

        $varients = [
            'configImg1' => $img1,
            'configImg2' => $img2,
            'configImg3' => $img3,
            'configImg4' => $img4,
            'size' => $filtrSize,
            'config_id' => $res[0]['config_id'],
            'color' => $colorID

        ];

        echo json_encode($varients);


    }
}