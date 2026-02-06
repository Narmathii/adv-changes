<?php

namespace App\Controllers\admin;

use App\Models\admin\BrandMasterModel;

class WishlistController extends BaseController
{

    public function wishlistDetails()
    {

        $session = \Config\Services::session();

        if ($session->get('login_sts') == "") {
            return redirect()->to('admin');
        } else {
            return view('admin/wishlist');
        }

    }


    public function getWishlistData()
    {
        $db = \Config\Database::connect();
        $data = $db->query("SELECT `prod_id`, `tbl_name`, COUNT(`prod_id`) AS wishlist FROM `tbl_wishlist` WHERE `flag` = 1 GROUP BY prod_id")->getResultArray();



        $allResults = []; // To store the final results

        for ($i = 0; $i < count($data); $i++) {
            $tableName = $data[$i]['tbl_name'];
            $prodID = $data[$i]['prod_id'];
            $count = $data[$i]['wishlist'];

            // Get product details
            $query = "SELECT `product_name`, `product_img` FROM $tableName WHERE `prod_id` = ?";
            $getResult = $db->query($query, [$prodID])->getResultArray();

            // Get user IDs who have the product in the wishlist
            $selectUser = "SELECT `user_id` FROM `tbl_wishlist` WHERE `prod_id` = ? AND `tbl_name` = ? AND `flag` = 1";
            $getResultArr = $db->query($selectUser, [$prodID, $tableName])->getResultArray();

            // Prepare an array to store user details
            $userDetails = [];

            foreach ($getResultArr as $result) {
                $userID = $result['user_id'];

                // Get user data
                $q1 = "SELECT `username`, `email` FROM `tbl_users` WHERE `user_id` = ?";
                $getUserData = $db->query($q1, [$userID])->getResultArray();

                // If no user data, set default values
                if (count($getUserData) <= 0) {
                    $userDetails[] = [
                        'user_id' => $userID,
                        'username' => "",
                        'email' => ""
                    ];
                } else {
                    $userDetails[] = [
                        'user_id' => $userID,
                        'username' => $getUserData[0]['username'],
                        'email' => $getUserData[0]['email']
                    ];
                }
            }

            // Merge product data with user details
            foreach ($getResult as $productData) {
                $allResults[] = [
                    'product_name' => $productData['product_name'],
                    'product_img' => $productData['product_img'],
                    'wishlist_count' => $count,
                    'users' => $userDetails // Include the combined user details here
                ];
            }
        }
        echo json_encode($allResults);
    }



}