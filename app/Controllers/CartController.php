<?php

namespace App\Controllers;
use App\Models\AddressModel;

use App\Models\CartModel;

class CartController extends BaseController
{

    private function headerlist()
    {
        $db = \Config\Database::connect();
        $res['brand_master'] = $db->query('SELECT * FROM `brand_master` WHERE  `flag` =1 ORDER BY brand_name ASC')->getResultArray();
        $res['brand'] = $db->query('SELECT `brand_id`,UPPER(`brand_name`) AS `brand_name` ,`brand_img` FROM `tbl_brand_master` WHERE  `flag` =1 ORDER BY brand_name ASC')->getResultArray();
        $res['modal'] = $db->query('SELECT `modal_id` ,`brand_id`, CONCAT(UPPER(SUBSTRING(modal_name, 1, 1)), LOWER(SUBSTRING(modal_name, 2))) AS `modal_name` FROM `tbl_modal_master` WHERE  `flag` = 1 ORDER BY modal_name ASC ')->getResultArray();

        $res['accessories'] = $db->query('SELECT `access_id`, UPPER(`access_title`) AS `access_title`  FROM `tbl_access_master` WHERE `flag` = 1  ORDER BY  `access_title` ASC;')->getResultArray();
        $res['sub_accessories'] = $db->query('SELECT `sub_access_id`,`access_id`, CONCAT(UPPER(SUBSTRING(`sub_access_name`, 1, 1)), LOWER(SUBSTRING(`sub_access_name`, 2))) AS `sub_access_name`  FROM `tbl_subaccess_master` WHERE `flag` = 1 ORDER BY sub_access_name ASC;')->getResultArray();

        $res['riding_menu'] = $db->query('SELECT `r_menu_id` , UPPER(`r_menu`) AS `r_menu`  FROM `tbl_riding_menu` WHERE `flag` =1 ORDER BY r_menu ASC;')->getResultArray();
        $res['riding_submenu'] = $db->query('SELECT `r_sub_id`,`r_menu_id`,CONCAT(UPPER(SUBSTRING(`r_sub_menu`, 1, 1)), LOWER(SUBSTRING(`r_sub_menu`, 2))) AS `r_sub_menu`  FROM `tbl_riding_submenu` WHERE flag =1 ORDER BY r_sub_menu ASC')->getResultArray();

        $res['lug_menu'] = $db->query('SELECT `lug_menu_id`,UPPER(`lug_menu`) AS `lug_menu`  FROM `tbl_luggage_menu` WHERE  `flag` = 1 ORDER BY lug_menu')->getResultArray();
        $res['lud_submenu'] = $db->query('SELECT `lug_submenu_id`,`lug_menu_id`,CONCAT(UPPER(SUBSTRING(`lug_submenu`, 1, 1)), LOWER(SUBSTRING(`lug_submenu`, 2))) AS `lug_submenu` FROM `tbl_luggage_submenu` WHERE  `flag` =1 ORDER BY lug_submenu ASC')->getResultArray();

        $res['h_menu'] = $db->query('SELECT `h_menu_id`,UPPER(`h_menu`) AS `h_menu` FROM `tbl_helmet_menu` WHERE `flag` = 1 ORDER BY h_menu ASC')->getResultArray();
        $res['h_submenu'] = $db->query('SELECT `h_submenu_id`,`h_menu_id`, CONCAT(UPPER(SUBSTRING(`h_submenu`, 1, 1)), LOWER(SUBSTRING(`h_submenu`, 2))) AS `h_submenu`,`hsubmenu_img`FROM `tbl_helmet_submenu` WHERE `flag` = 1 ORDER BY h_submenu ASC')->getResultArray();

        $res['h_submenu_list'] = $db->query('SELECT `h_submenu_id`,`h_menu_id`, CONCAT(UPPER(SUBSTRING(`h_submenu`, 1, 1)), LOWER(SUBSTRING(`h_submenu`, 2))) AS `h_submenu`,`hsubmenu_img`FROM `tbl_helmet_submenu` WHERE `flag` = 1 AND  `h_menu_id` = 2 ORDER BY h_submenu ASC')->getResultArray();

        $res['camp_menu'] = $db->query('SELECT `camp_menu_id` ,UPPER(`camp_menu`) AS `camp_menu` FROM `tbl_camping_menu` WHERE flag = 1 ORDER BY camp_menu ASC;')->getResultArray();
        $res['camp_submenu'] = $db->query('SELECT `c_submenu_id`,`camp_menuid`,  CONCAT(UPPER(SUBSTRING(`c_submenu`, 1, 1)), LOWER(SUBSTRING(`c_submenu`, 2))) AS `c_submenu`,`csubmenu_img` FROM `tbl_camping_submenu` WHERE flag = 1 ORDER BY `c_submenu` ASC')->getResultArray();
        return $res;
    }

    public function cartList()
    {

        $this->session = \Config\Services::session();
        // $specificData = session()->get('user_id');
        // echo $specificData;exit;

        $db = \Config\Database::connect();
        $res = $this->headerlist();

        // to get cart count 
        $userID = session()->get('user_id');

        $query = "SELECT * FROM tbl_user_cart WHERE user_id = ? AND flag =1";
        $usercount = $db->query($query, [$userID])->getResultArray();
        if ($usercount > 0) {
            $res['cart_count'] = sizeof($usercount);

        } else {
            $res['cart_count'] = 0;
        }
        // end cart count

        $q1 = "SELECT COUNT(cart_id) AS totl_item FROM `tbl_user_cart` WHERE `user_id` = ?  AND `flag` = 1";
        $getData = $db->query($q1, [$userID])->getRow();

        $res['total_items'] = $getData->totl_item;
        // Get cart details
        $query = "SELECT `table_name`,`prod_id`,color,size FROM `tbl_user_cart` WHERE `flag`= 1 AND  user_id = ?";
        $cartDetail = $db->query($query, [$userID])->getResultArray();


        $data = [];
        foreach ($cartDetail as $item) {
            $tableName = $item['table_name'];
            $prodID = $item['prod_id'];
            $color = $item['color'];
            $size = $item['size'];


            $query = "SELECT a.prod_id, a.product_name, a.product_price, a.offer_price, a.product_img,a.quantity AS total_stock,
                             b.quantity, b.cart_id, b.user_id, b.table_name, b.sub_total, b.size,b.config_image1,b.size_stock
                            
                      FROM $tableName AS a 
                      INNER JOIN tbl_user_cart AS b ON a.prod_id = b.prod_id
                     
                      WHERE b.flag = 1 AND a.prod_id = ? AND b.user_id = ? AND b.size = ?";

            $result = $db->query($query, [$prodID, $userID, $size])->getRow();
            if ($result) {
                $data[] = $result;
            }
        }

        $res['cart_product'] = $data;

        // GET ADDRESS DETAILS 
        $addressQry = "SELECT  a.* , b.state_title , c.dist_name,d.number,d.username FROM
        `tbl_user_address` AS a INNER JOIN tbl_state AS b ON a.`state_id` = b.state_id
        INNER JOIN tbl_district  AS c  ON a.`dist_id` = c.dist_id 
        INNER JOIN tbl_users AS d  ON d.user_id = a.user_id 
        WHERE a.`flag` = 1 AND a.`user_id` = ?";

        $res['address'] = $db->query($addressQry, [$userID])->getResultArray();


        $stateqry = "SELECT `state_id` FROM `tbl_user_address` WHERE `default_addr` = 1 AND `flag` = 1 AND user_id = ?";

        $res['defaultState'] = $db->query($stateqry, [$userID])->getResultArray();


        $res['courier_type'] = $db->query("SELECT courier_id, courier_name FROM tbl_couriers WHERE flag = 1")->getResultArray();


        $res['state'] = $db->query("SELECT `state_id`,`state_title` FROM `tbl_state` WHERE `flag` =1")->getResultArray();
        // to get wishlist count 
        $res['wishlist_count'] = $this->getWishlistCount();
        $res['user_id'] = session()->get('user_id');


        return view('cartList', $res);
    }

    public function getEmail()
    {
        $db = \Config\Database::connect();
        $userID = session()->get('user_id');

        $emailQry = "SELECT `email`  FROM `tbl_users` WHERE `user_id` = ?";
        $checkEmail = $db->query($emailQry, [$userID])->getResultArray();


        $res['email'] = $checkEmail[0]['email'];

        echo json_encode($res);
    }

    public function changeAddress()
    {

        $db = \Config\Database::connect();


        $addID = $this->request->getPost('add_id');

        $query = "SELECT a.* , b.state_title, c.dist_name   FROM `tbl_user_address` AS a 
                  INNER JOIN  tbl_state AS b ON a.state_id = b.state_id 
                  INNER JOIN tbl_district AS c ON a.dist_id = c.dist_id
                  WHERE a.`add_id` = ? AND a.`flag` = 1;";
        $getAddress = $db->query($query, [$addID])->getResultArray();

        return json_encode($getAddress);

    }


    public function getDistrict()
    {


        $db = \Config\Database::connect();
        $stateID = $this->request->getPost('state_id');

        $getData = $db->query("SELECT a.`state_title`, b.`dist_id`,b.`dist_name` FROM 
        tbl_state AS a INNER JOIN tbl_district AS b 
        ON a.state_id = b.state_id WHERE  a.`flag` = 1 AND b.state_id = $stateID;")->getResultArray();

        echo json_encode($getData);
    }



    public function insertEmail()
    {
        $userID = session()->get('user_id');
        $db = \Config\Database::connect();
        $email = $this->request->getPost('email');

        $query = "UPDATE tbl_users SET email = ? WHERE user_id = ? ";
        $updateData = $db->query($query, [$email, $userID]);

        $affectedRows = $db->affectedRows();
        if ($affectedRows == 1) {
            $result['code'] = 200;
            $result['msg'] = 'Email added Successfully';
            $result['status'] = 'success';
        } else {
            $result['code'] = 400;
            $result['msg'] = 'Email added Successfully';
            $result['status'] = 'failure';
        }

        echo json_encode($result);


    }

    public function updateEmail()
    {
        $userID = session()->get('user_id');
        $db = \Config\Database::connect();
        $email = $this->request->getPost('email');

        $getEmail = 'SELECT COUNT(`user_id`) AS user_count 
             FROM `tbl_users` 
             WHERE `user_id` = ? AND `email` != "" AND `email` LIKE "%@%"';


        $getEmailData = $db->query($getEmail, [$userID])->getRow();


        if ($getEmailData && isset($getEmailData->user_count)) {
            $emailCount = $getEmailData->user_count;

            if ($emailCount > 0) {

                $query = "UPDATE tbl_users SET email = ? WHERE user_id = ?";
                $affectedRows = $db->query($query, [$email, $userID]);



                if ($affectedRows > 0) {
                    $result['code'] = 200;
                    $result['msg'] = 'Email Updated Successfully';
                    $result['status'] = 'success';
                    $result['email'] = $email;
                } else {
                    $result['code'] = 400;
                    $result['msg'] = 'Email Update Failed';
                    $result['status'] = 'failure';
                    $result['email'] = "";
                }
            } else {

                $query = "UPDATE tbl_users SET email = ? WHERE user_id = ?";
                $affectedRows = $db->query($query, [$email, $userID]);

                if ($affectedRows > 0) {
                    $result['code'] = 200;
                    $result['msg'] = 'Email Added Successfully';
                    $result['status'] = 'success';
                    $result['email'] = $email;

                } else {
                    $result['code'] = 400;
                    $result['msg'] = 'Email Update Failed';
                    $result['status'] = 'failure';
                    $result['email'] = " ";
                }
            }
        } else {

            $result['code'] = 500;
            $result['msg'] = 'Database Query Failed';
            $result['status'] = 'error';
            $result['email'] = " ";
        }

        echo json_encode($result);
    }

    public function insertCartAddress()
    {
        $userID = session()->get('user_id');
        $AddressModel = new AddressModel;
        $db = \Config\Database::connect();

        $stateID = $this->request->getPost('state_id');
        $data = $this->request->getPost();



        $distID = $this->request->getPost('dist_id');
        $landMark = $this->request->getPost('landmark');
        $city = $this->request->getPost('city');
        $address = $this->request->getPost('address');
        $pincode = $this->request->getPost('pincode');
        $defaultAddr = $this->request->getPost('default_addr');

        $checkDefault = $defaultAddr == "true" ? 1 : 0;

        $query = "SELECT * FROM `tbl_user_address` WHERE `flag` = 1 AND `user_id` = ? AND `default_addr` = 1";
        $getAddr = $db->query($query, [$userID])->getResult();

        if ($defaultAddr == 'true') {
            if (count($getAddr) > 0) {
                $oldID = $getAddr[0]->add_id;

                $query = "UPDATE tbl_user_address SET default_addr = 0 WHERE add_id = ? AND user_id = ?";
                $updateAddr = $db->query($query, [$oldID, $userID]);
            }
        }

        $data = [
            "user_id" => $userID,
            "state_id" => $stateID,
            "dist_id" => $distID,
            "landmark" => $landMark,
            "city" => $city,
            "address" => $address,
            "pincode" => $pincode,
            "default_addr" => $checkDefault
        ];

        $insertData = $AddressModel->insert($data);
        $affectedRows = $db->affectedRows();
        if ($affectedRows === 1 && $insertData) {
            $result['code'] = 200;
            $result['msg'] = 'Address added Successfully';
            $result['status'] = 'success';
            $result['csrf'] = csrf_hash();

            echo json_encode($result);
        } else {
            $result['code'] = 400;
            $result['status'] = 'Failed';
            $result['msg'] = 'Something wrong';
            $result['csrf'] = csrf_hash();

            echo json_encode($result);
        }

    }


    public function updateCartAddress()
    {
        $db = \Config\Database::connect();

        $data = $this->request->getPost();


        $add_id = $this->request->getPost('add_id');
        $state_id = $this->request->getPost('state_id');
        $dist_id = $this->request->getPost('dist_id');
        $landmark = $this->request->getPost('landmark');
        $city = $this->request->getPost('city');
        $address = $this->request->getPost('address');
        $pincode = $this->request->getPost('pincode');
        $default_addr = $this->request->getPost('default_addr');
        $checkDefault = $default_addr == "true" ? 1 : 0;
        $userID = session()->get('user_id');


        $query = "SELECT add_id FROM `tbl_user_address` WHERE `flag` = 1 AND `user_id` = ? AND `default_addr` = 1";
        $getAddr = $db->query($query, [$userID])->getRow();
        $old_addID = $getAddr->add_id;


        if ($old_addID == $add_id && $checkDefault == 1) {

            $query = "UPDATE tbl_user_address 
            SET state_id = ?, dist_id = ?, landmark = ?, city = ?, address = ?, pincode = ?, default_addr = ? 
            WHERE add_id = ?";
            $updateData = $db->query($query, [$state_id, $dist_id, $landmark, $city, $address, $pincode, $checkDefault, $add_id]);
            $affectedRows = $db->affectedRows();
        } else if ($old_addID != $add_id && $checkDefault == 1) {

            $query = "SELECT add_id FROM `tbl_user_address` WHERE `flag` = 1 AND `user_id` = ? AND `default_addr` = 1";
            $getAddr = $db->query($query, [$userID])->getResultArray();


            $count = count($getAddr);

            if ($count == 1) {
                $oldID = $getAddr[0]['add_id'];

                //update default 
                $updateqry = "UPDATE tbl_user_address SET `default_addr` = 0 WHERE `add_id` = ? AND user_id = ?";
                $updatedefault = $db->query($updateqry, [$oldID, $userID]);


                if ($updatedefault) {
                    $query = "UPDATE tbl_user_address 
                    SET state_id = ?, dist_id = ?, landmark = ?, city = ?, address = ?, pincode = ?, default_addr = ? 
                    WHERE add_id = ?";
                    $updateData = $db->query($query, [$state_id, $dist_id, $landmark, $city, $address, $pincode, $checkDefault, $add_id]);
                    $affectedRows = $db->affectedRows();
                }
                $affectedRows = $db->affectedRows();

            } else {
                $query = "UPDATE tbl_user_address 
                    SET state_id = ?, dist_id = ?, landmark = ?, city = ?, address = ?, pincode = ?, default_addr = ? 
                    WHERE add_id = ?";
                $updateData = $db->query($query, [$state_id, $dist_id, $landmark, $city, $address, $pincode, $checkDefault, $add_id]);
                $affectedRows = $db->affectedRows();

                $affectedRows = $db->affectedRows();
            }

        } else {


            $query = "UPDATE tbl_user_address 
            SET state_id = ?, dist_id = ?, landmark = ?, city = ?, address = ?, pincode = ?, default_addr = ? 
            WHERE add_id = ?";
            $updateData = $db->query($query, [$state_id, $dist_id, $landmark, $city, $address, $pincode, $checkDefault, $add_id]);
            $affectedRows = $db->affectedRows();
        }



        if ($affectedRows == 1) {
            $result['code'] = 200;
            $result['msg'] = 'Data updated successfully';
            $result['status'] = 'success';
            // $result['csrf'] = csrf_hash();
            echo json_encode($result);
        } else {
            $result['code'] = 400;
            $result['msg'] = 'No data updated or something went wrong';
            $result['status'] = 'failure';
            // $result['csrf'] = csrf_hash();
            echo json_encode($result);
        }
    }


    public function getWishlistCount()
    {
        $db = \Config\Database::connect();
        $userID = session()->get('user_id');

        $query = "SELECT * FROM tbl_wishlist WHERE user_id = ? AND flag =1";
        $usercount = $db->query($query, [$userID])->getResultArray();
        if (!empty($usercount)) {
            $res = sizeof($usercount);
        } else {
            $res = 0;
        }
        return $res;
    }

    // ************************************************** USER CART   *************************************************************************

    public function userCart()
    {
        $cartModel = new CartModel;
        $db = \Config\Database::connect();

        $this->session = \Config\Services::session();

        $data = $this->request->getPost();


        $tblName = $this->request->getPost('table_name');
        $prodID = $this->request->getPost('prod_id');
        $qty = $this->request->getPost('quantity');
        $prodPrice = $this->request->getPost('prod_price');
        $configImage = $this->request->getPost('config_image1');
        $size = $this->request->getPost('size');
        $userID = $this->session->get('user_id');
        $size_Stock = $this->request->getPost('size_stock');

        if ($size == "") {
            $hexCode = 0;
            $size = 0;
        }


        $sql = "SELECT * FROM tbl_user_cart WHERE  prod_id= ? AND table_name = ? AND size = ? AND user_id =? AND flag = 1";
        $getResult = $db->query($sql, [$prodID, $tblName, $size, $userID])->getResultArray();

        $cartID = $getResult[0]['cart_id'];


        // getOrginal Products Price 
        $q1 = "SELECT `offer_price` ,`quantity`  FROM $tblName WHERE  `flag` = 1 AND `prod_id` = ?";
        $getOriginalProducts = $db->query($q1, [$prodID])->getRow();

        $OriginalPrice = $getOriginalProducts->offer_price;
        $OriginalQty = $getOriginalProducts->quantity;



        if (count($getResult) > 0) {

            if ($prodPrice == $OriginalPrice && $qty <= $OriginalQty) {
                $finalProdPrice = $prodPrice;
            } else {
                $finalProdPrice = $OriginalPrice;
            }

            $proPrice = number_format((float) $finalProdPrice, 2, '.', '');
            $totalAmt = $proPrice * $qty;
            $subTotal = number_format((float) $totalAmt, 2, '.', '');

            $query = "UPDATE tbl_user_cart 
                      SET quantity = ?, prod_price = ?, sub_total = ?, color = ?, hex_code = ?, size = ?, config_image1 = ?  
                      WHERE user_id = ? AND table_name = ? AND prod_id = ? AND flag = 1 AND cart_id = ? ";

            $updateData = $db->query($query, [
                $qty,
                $proPrice,
                $subTotal,
                0,
                0,
                $size,
                $configImage,
                $userID,
                $tblName,
                $prodID,
                $cartID
            ]);


            // Check the number of affected rows
            $affectedRows = $db->affectedRows();

            if ($updateData && $affectedRows) {
                $result["status"] = "success";
                $result["code"] = 200;
                $result["msg"] = "Product qty Updated to cart";
                echo json_encode($result);
            } else {
                $result["status"] = "fail";
                $result["code"] = 400;
                $result["msg"] = "Product Already in cart!";
                echo json_encode($result);
            }


        } else {

            if ($prodPrice == $OriginalPrice && $qty <= $OriginalQty) {
                $finalProdPrice = $prodPrice;
            } else {
                $finalProdPrice = $OriginalPrice;
            }

            $prodPrice = number_format((float) $finalProdPrice, 2, '.', '');
            $totalAmt = $prodPrice * $qty;
            $subTotal = number_format((float) $totalAmt, 2, '.', '');


            $insert = [
                'user_id' => $userID,
                'table_name' => $tblName,
                'prod_id' => $prodID,
                'quantity' => $qty,
                'prod_price' => $prodPrice,
                'sub_total' => $subTotal,
                'color' => 0,
                'hex_code' => 0,
                'size' => $size,
                'config_image1' => $configImage,
                'size_stock' => $size_Stock


            ];
            $insertData = $cartModel->insert($insert);


            $affectedRows = $db->affectedRows();


            if ($insertData && $affectedRows) {
                $result["status"] = "success";
                $result["code"] = 200;
                $result["msg"] = "Product Added to cart";
                $result['csrf_test_name'] = csrf_hash();
                echo json_encode($result);
            } else {
                $result["status"] = "fail";
                $result["code"] = 400;
                $result["msg"] = "Product Added Failure!";
                $result['csrf_test_name'] = csrf_hash();
                echo json_encode($result);
            }
        }
    }


    // ************************************************** DELETE CART *************************************************************************

    public function deleteCart()
    {

        $db = \Config\Database::connect();

        $cartID = $this->request->getPost('cart_id');
        // $csrf = $this->request->getHeader('X-CSRF-TOKEN')->getValue();


        $query = "UPDATE tbl_user_cart SET `flag` = 0 WHERE `cart_id` = ?";
        $dltData = $db->query($query, $cartID);

        $affectedRows = $db->affectedRows();

        if ($dltData && $affectedRows) {
            $result['code'] = 200;
            $result['msg'] = 'Product Deleted!!';
            $result['status'] = 'success';
            // $result['csrf'] = csrf_hash();

            echo json_encode($result);
        } else {
            $result['code'] = 400;
            $result['msg'] = 'Something Wrong';
            $result['status'] = 'failure';
            // $result['csrf'] = csrf_hash();
            echo json_encode($result);
        }
    }

    // ************************************************** UPDATE CART *************************************************************************

    public function updateCart()
    {
        $db = \Config\Database::connect();

        $cartID = $this->request->getPost('cart_id');
        $qty = (int) $this->request->getPost('quantity');
        $userID = session()->get("user_id");


        $getCart = $db->query("SELECT * FROM tbl_user_cart WHERE cart_id = ?", [$cartID])->getRowArray();
        if (!$getCart) {
            return json_encode([
                'code' => 404,
                'status' => 'Cart item not found',
            ]);
        }

        $prodID = $getCart['prod_id'];
        $tableName = $getCart['table_name'];

        $getPrice = $db->query("SELECT offer_price ,quantity FROM `$tableName` WHERE prod_id = ?", [$prodID])->getRowArray();
        $quantityData = $getPrice['quantity'];

        if (!$getPrice) {
            return json_encode([
                'code' => 404,
                'status' => 'Product not found',
                'csrf_token' => csrf_hash()
            ]);
        }

        if ($qty <= 0 || $qty > $quantityData) {
            return json_encode([
                'code' => 404,
                'status' => 'Invalid Product Quantity',
            ]);
        }

        $price = (float) $getPrice['offer_price'];
        $subTotal = $qty * $price;
        $formattedSubTotal = number_format($subTotal, 2, '.', '');

        // Update cart
        $updateQuery = "UPDATE tbl_user_cart SET quantity = ?, sub_total = ? WHERE cart_id = ? AND flag = 1";
        $update = $db->query($updateQuery, [$qty, $formattedSubTotal, $cartID]);

        if ($update) {

            // Recalculate full cart total
            $totalRow = $db->query("SELECT SUM(sub_total) AS total FROM tbl_user_cart WHERE user_id = ? AND flag = 1", [$userID])->getRowArray();
            $grandTotal = $totalRow['total'] ?? 0;
            $formattedTotal = number_format($grandTotal, 2, '.', '');

            return json_encode([
                'code' => 200,
                'status' => 'success',
                'sub_total' => $formattedSubTotal,
                'total' => $formattedTotal,
                'csrf_token' => csrf_hash()
            ]);
        }

        return json_encode([
            'code' => 400,
            'status' => 'Failed to update cart',
            'csrf_token' => csrf_hash()
        ]);
    }


    public function getInitialCart()
    {
        $db = \Config\Database::connect();
        $userID = session()->get("user_id");

        if (!$userID) {
            $res['message'] = "User not authenticated.";
            $res['status_code'] = 400;
            echo json_encode($res);
            return;
        }

        $cartItems = $db->query(
            "SELECT prod_price, prod_id, quantity FROM tbl_user_cart WHERE user_id = ? AND flag = 1",
            [$userID]
        )->getResultArray();

        if (empty($cartItems)) {
            $res['message'] = "No items in the cart.";
            $res['status_code'] = 400;
            echo json_encode($res);
            return;
        }

        $grandTotal = 0;
        foreach ($cartItems as $item) {
            $itemTotal = (float) $item['prod_price'];
            $cartTotal = $itemTotal * $item['quantity'];
            $grandTotal += $cartTotal;
        }

        $res['total_price'] = $grandTotal;
        $res['status_code'] = 200;
        $res['message'] = "Cart fetched successfully.";

        echo json_encode($res);
    }


    // ************************************************** UPDATE Address *************************************************************************

    public function updateDefaultAddr()
    {
        $db = \Config\Database::connect();
        $addrID = $this->request->getPost("add_id");

        $userID = session()->get("user_id");



        $query = "SELECT * FROM `tbl_user_address` WHERE `flag` = 1 AND `user_id` = ? AND `default_addr` = 1";
        $getAddr = $db->query($query, [$userID])->getResult();




        if (count($getAddr) > 0) {
            $oldID = $getAddr[0]->add_id;

            $query = "UPDATE tbl_user_address SET default_addr = 0 WHERE add_id = ? AND user_id = ?";
            $updateAddr = $db->query($query, [$oldID, $userID]);
            if ($updateAddr) {

                $query = "UPDATE tbl_user_address SET default_addr = 1 WHERE add_id = ? AND user_id = ?";
                $updateAddrr = $db->query($query, [$addrID, $userID]);

                $getDistID = $db->query("SELECT `dist_id`, `state_id` FROM `tbl_user_address` WHERE `default_addr` =  1 AND `user_id` = $userID  AND `flag` = 1")->getRow();


                if ($updateAddrr) {
                    $res['code'] = 200;
                    $res['msg'] = "Default address changed";
                    $res['dist_id'] = $getDistID->dist_id;
                    $res['state_id'] = $getDistID->state_id;
                }

            }
        } else {
            $query = "SELECT * FROM `tbl_user_address` WHERE `flag` = 1 AND `user_id` = ?";
            $getAddr = $db->query($query, [$userID])->getResult();

            if ($getAddr > 0) {
                $query = "UPDATE tbl_user_address SET default_addr = 1 WHERE add_id = ? AND user_id = ?";
                $updateAddrr = $db->query($query, [$addrID, $userID]);
            }


            $getDistID = $db->query("SELECT `dist_id`, `state_id` FROM `tbl_user_address` WHERE `default_addr` =  1 AND `user_id` = $userID  AND `flag` = 1")->getRow();
            $res['code'] = 200;
            $res['msg'] = "Default address changed";
            $res['dist_id'] = $getDistID->dist_id;
            $res['state_id'] = $getDistID->state_id;
        }
        echo json_encode($res);
    }


    // ************************************************** Assign Charges *************************************************************************

    public function assignCharges()
    {
        $db = \Config\Database::connect();
        $stateID = $this->request->getPost("state_id");
        $courierType = $this->request->getPost("courierType");

        $userID = session()->get("user_id");

        if ($courierType == 1) {
            $query = "SELECT `charges` FROM `tbl_courier_charges` WHERE `flag` = 1 AND `state_id` = ? AND `active_sts` = 1 AND courier_id = ?
               AND dist_id = 0";
            $getCharge = $db->query($query, [$stateID, $courierType])->getRow();
            $charge = $getCharge->charges;


            $query = "SELECT * FROM `tbl_user_cart` WHERE `flag` = 1 AND `user_id` = ?";
            $cartList = $db->query($query, [$userID])->getResultArray();

            $totalWeightKg = 0;

            foreach ($cartList as $cartItem) {
                $prodID = $cartItem['prod_id'];
                $tblName = $cartItem['table_name'];
                $quantity = $cartItem['quantity'];


                $query = "SELECT `weight` FROM $tblName WHERE `flag` = 1 AND `prod_id` = ? AND tbl_name = ?";
                $productQty = $db->query($query, [$prodID, $tblName])->getRow();

                if (!empty($productQty)) {
                    $prodWeight = $productQty->weight;

                    $prodKg = $prodWeight / 1000;
                    $totalWeightKg += $quantity * $prodKg;
                }

            }


            if ($totalWeightKg <= 1) {
                $totalCharge = $charge;
            } else {
                $totalCharge = $charge * ceil($totalWeightKg);

            }

            $GST = 0.18;
            $totalWithoutGST = $totalCharge + 10;
            $total = $totalWithoutGST + ($totalWithoutGST * $GST);
            $finalCharge = ceil($total);

        } else if ($courierType == 0) {

            // $query = "SELECT * FROM `tbl_user_cart` WHERE `flag` = 1 AND `user_id` = ?";
            // $cartList = $db->query($query, [$userID])->getResultArray();

            // $totalWeightKg = 0;

            // foreach ($cartList as $cartItem) {
            //     $prodID = $cartItem['prod_id'];
            //     $tblName = $cartItem['table_name'];
            //     $quantity = $cartItem['quantity'];


            //     $query = "SELECT `weight` FROM $tblName WHERE `flag` = 1 AND `prod_id` = ? AND tbl_name = ?";
            //     $productQty = $db->query($query, [$prodID, $tblName])->getRow();

            //     if (!empty($productQty)) {
            //         $prodWeight = $productQty->weight;

            //         $prodKg = $prodWeight / 1000;
            //         $totalWeightKg += $quantity * $prodKg;

            //     }

            // }

            // if ($totalWeightKg <= 1) {
            //     $finalCharge = 100;
            // } else {
            //     $GST = 0.18;
            //     $totalCharge = 100 * ceil($totalWeightKg);
            //     $totalWithoutGST = $totalCharge;
            //     $total = $totalWithoutGST + ($totalWithoutGST * $GST);
            //     $finalCharge = ceil($total);
            // }

            $finalCharge = 0;
        }
        echo json_encode($finalCharge);
    }

    public function getDist()
    {
        $db = \Config\Database::connect();

        $userID = $this->request->getPost('user_id');
        $res = $db->query("SELECT `dist_id` FROM `tbl_user_address` WHERE `default_addr` = 1 AND `user_id` = $userID AND `flag` = 1")->getResultArray();
        echo json_encode($res);
    }

}
