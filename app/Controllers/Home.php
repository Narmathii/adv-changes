<?php

namespace App\Controllers;

use App\Models\FrequentModel;
use App\Models\TransactionModel;



class Home extends BaseController
{

    public $db;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    private function headerlist()
    {
        $db = \Config\Database::connect();
        $res['brand_master'] = $db->query('SELECT * FROM `brand_master` WHERE  `flag` =1 ORDER BY brand_name ASC')->getResultArray();
        $res['brand'] = $db->query('SELECT `brand_id`,UPPER(`brand_name`) AS `brand_name` ,`brand_img` FROM `tbl_brand_master` WHERE  `flag` =1 ORDER BY brand_name ASC')->getResultArray();
        $res['modal'] = $db->query('SELECT `modal_id` ,`brand_id`, CONCAT(UPPER(SUBSTRING(modal_name, 1, 1)), LOWER(SUBSTRING(modal_name, 2))) AS `modal_name` FROM `tbl_modal_master` WHERE  `flag` = 1 ORDER BY modal_name ASC ')->getResultArray();

        $res['accessories'] = $db->query('SELECT `access_id`, UPPER(`access_title`) AS `access_title`  FROM `tbl_access_master` WHERE `flag` = 1 AND `is_active` =1  ORDER BY  `access_title` ASC;')->getResultArray();
        $res['sub_accessories'] = $db->query('SELECT `sub_access_id`, `access_id`, 
       CONCAT(UPPER(SUBSTRING(`sub_access_name`, 1, 1)), LOWER(SUBSTRING(`sub_access_name`, 2))) AS `sub_access_name`  
        FROM `tbl_subaccess_master` 
        WHERE `flag` = 1 
        ORDER BY sub_access_name ASC
        ')->getResultArray();


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
    public function index(): string
    {
        $res = $this->headerlist();
        $db = \Config\Database::connect();

        $session = \Config\Services::session();


        $res['banner'] = $db->query('SELECT `mobile_img`,`desktop_img`,`link` FROM `tbl_banner` WHERE  `flag` = 1 ORDER BY `banner_id` ASC')->getResultArray();

        $res['youtube'] = $db->query('SELECT `ytube_link`,`ytube_img` FROM `tbl_youtube` WHERE  `flag` = 1')->getResultArray();

        $res['helmets'] = $db->query(
            "SELECT a.h_menu , b.*,c.h_submenu 
            FROM tbl_helmet_menu AS a INNER JOIN tbl_helmet_products AS b 
            ON a.h_menu_id = b.h_menu_id 
            INNER JOIN  tbl_helmet_submenu AS c  
            ON b.h_submenu_id = c.h_submenu_id
            WHERE 
            a.h_menu = 'helmet' AND b.`flag` = 1
        "
        )->getResultArray();



        if (session()->get('username') != " ") {
            $res['name'] = session()->get('username');
        }


        // to get cart count 
        $userID = session()->get('user_id');
        $query = "SELECT * FROM tbl_user_cart WHERE user_id = ? AND flag =1";
        $usercount = $db->query($query, [$userID])->getResultArray();
        if ($usercount > 0) {
            $res['cart_count'] = sizeof($usercount);

        } else {
            $res['cart_count'] = 0;
        }

        // to get wishlist count 
        $res['wishlist_count'] = $this->getWishlistCount();

        // get HOT SALE
        $res['hotsale'] = $db->query('SELECT prod_id, brand_id, modal_id, product_name, billing_name, product_price, 
           offer_price, offer_type, offer_details, arrival_status, stock_status, 
           redirect_url, product_img, img_1, img_2, img_3, img_4, img_5, img_6, 
           img_7, img_8, img_9, img_10, prod_desc, 
           hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
           specifications, flag, 1 AS order_col
    FROM tbl_products
    WHERE flag = 1 AND hot_sale = 1 AND offer_type = 0 AND quantity != 0
    UNION ALL
    SELECT prod_id, access_id AS brand_id, sub_access_id AS modal_id, product_name, 
           billing_name, product_price, offer_price, offer_type, offer_details, 
           arrival_status, stock_status, redirect_url, product_img, img_1, img_2, 
           img_3, img_4, img_5, img_6, img_7, img_8, img_9, img_10, prod_desc,  hot_sale, tbl_name, 
           search_brand, weight, weight_units, quantity, specifications, flag, 2 AS order_col
    FROM tbl_accessories_list
    WHERE flag = 1 AND hot_sale = 1 AND offer_type = 0 AND quantity != 0
    UNION ALL
    SELECT prod_id, r_menu_id AS brand_id, r_sub_id AS modal_id, product_name, 
           billing_name, product_price, offer_price, offer_type, offer_details, 
           arrival_status, stock_status, redirect_url, product_img, img_1, img_2, img_3, 
           img_4, img_5, img_6, img_7, img_8, img_9, img_10, prod_desc,  hot_sale, tbl_name, search_brand, weight, 
           weight_units, quantity, specifications, flag, 3 AS order_col
    FROM tbl_rproduct_list
    WHERE flag = 1 AND hot_sale = 1 AND offer_type = 0 AND quantity != 0
    UNION ALL
    SELECT prod_id, h_menu_id AS brand_id, h_submenu_id AS modal_id, product_name, 
           billing_name, product_price, offer_price, offer_type, offer_details, arrival_status, 
           stock_status, redirect_url, product_img, img_1, img_2, img_3, img_4, img_5, img_6, 
           img_7, img_8, img_9, img_10, prod_desc, hot_sale, tbl_name, search_brand, weight, weight_units, 
           quantity, specifications, flag, 4 AS order_col
    FROM tbl_helmet_products
    WHERE flag = 1 AND hot_sale = 1 AND offer_type = 0 AND quantity != 0
    UNION ALL
    SELECT prod_id, lug_menu_id AS brand_id, lug_submenu_id AS modal_id, product_name, 
           billing_name, product_price, offer_price, offer_type, offer_details, arrival_status, 
           stock_status, redirect_url, product_img, img_1, img_2, img_3, img_4, img_5, img_6, 
           img_7, img_8, img_9, img_10, prod_desc, hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
           specifications, flag, 5 AS order_col
    FROM tbl_luggagee_products
    WHERE flag = 1 AND hot_sale = 1 AND offer_type = 0 AND quantity != 0
    UNION ALL
    SELECT prod_id, camp_menu_id AS brand_id, c_submenu_id AS modal_id, product_name, 
           billing_name, product_price, offer_price, offer_type, offer_details, arrival_status, 
           stock_status, redirect_url, product_img, img_1, img_2, img_3, img_4, img_5, img_6, 
           img_7, img_8, img_9, img_10, prod_desc, hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
           specifications, flag, 6 AS order_col
    FROM tbl_camping_products
    WHERE flag = 1 AND hot_sale = 1 AND offer_type = 0 AND quantity != 0
    ORDER BY order_col, prod_id')->getResultArray();


        // get new arrivals
        $res['new_arrivals'] = $db->query("SELECT prod_id, access_id AS brand_id, sub_access_id AS modal_id, product_name, 
           billing_name, product_price, offer_price, offer_type, offer_details, 
           arrival_status, stock_status, redirect_url, product_img, img_1, img_2, 
           img_3, img_4, img_5, img_6, img_7, img_8, img_9, img_10, prod_desc,  hot_sale, tbl_name, 
           search_brand, weight, weight_units, quantity, specifications, flag, 2 AS order_col
    FROM tbl_accessories_list
     WHERE flag = 1 AND arrival_status =  1 AND quantity != 0
    UNION ALL
    SELECT prod_id, r_menu_id AS brand_id, r_sub_id AS modal_id, product_name, 
           billing_name, product_price, offer_price, offer_type, offer_details, 
           arrival_status, stock_status, redirect_url, product_img, img_1, img_2, img_3, 
           img_4, img_5, img_6, img_7, img_8, img_9, img_10, prod_desc, hot_sale, tbl_name, search_brand, weight, 
           weight_units, quantity, specifications, flag, 3 AS order_col
    FROM tbl_rproduct_list
     WHERE flag = 1 AND arrival_status =  1 AND quantity != 0
    UNION ALL
    SELECT prod_id, h_menu_id AS brand_id, h_submenu_id AS modal_id, product_name, 
           billing_name, product_price, offer_price, offer_type, offer_details, arrival_status, 
           stock_status, redirect_url, product_img, img_1, img_2, img_3, img_4, img_5, img_6, 
           img_7, img_8, img_9, img_10, prod_desc,  hot_sale, tbl_name, search_brand, weight, weight_units, 
           quantity, specifications, flag, 4 AS order_col
    FROM tbl_helmet_products 
     WHERE flag = 1 AND arrival_status =  1 AND quantity != 0
    UNION ALL
    SELECT prod_id, lug_menu_id AS brand_id, lug_submenu_id AS modal_id, product_name, 
           billing_name, product_price, offer_price, offer_type, offer_details, arrival_status, 
           stock_status, redirect_url, product_img, img_1, img_2, img_3, img_4, img_5, img_6, 
           img_7, img_8, img_9, img_10, prod_desc, hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
           specifications, flag, 5 AS order_col
    FROM tbl_luggagee_products
     WHERE flag = 1 AND arrival_status =  1 AND quantity != 0
    UNION ALL
    SELECT prod_id, camp_menu_id AS brand_id, c_submenu_id AS modal_id, product_name, 
           billing_name, product_price, offer_price, offer_type, offer_details, arrival_status, 
           stock_status, redirect_url, product_img, img_1, img_2, img_3, img_4, img_5, img_6, 
           img_7, img_8, img_9, img_10, prod_desc,  hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
           specifications, flag, 6 AS order_col
    FROM tbl_camping_products
     WHERE flag = 1 AND arrival_status =  1 AND quantity != 0
    ORDER BY order_col, prod_id DESC")->getResultArray();


        // Get wishList details
        $query = "SELECT `tbl_name`,`prod_id` FROM `tbl_wishlist` WHERE `flag`= 1 AND  user_id = ?";
        $wishListDetail = $db->query($query, [$userID])->getResultArray();

        $data = [];
        foreach ($wishListDetail as $item) {
            $tableName = $item['tbl_name'];
            $prodID = $item['prod_id'];
            $query = "SELECT a.prod_id,a.product_name, a.product_price, a.offer_price, a.product_img, a.stock_status,
        b.wishlist_id,b.tbl_name
        FROM $tableName AS a 
        
        INNER JOIN tbl_wishlist AS b 
        ON a.prod_id = b.prod_id
        WHERE b.flag = 1 AND a.prod_id = $prodID AND b.user_id = '$userID'";
            $result = $db->query($query)->getRow();
            $data[] = $result;
        }
        $res['wishListProd'] = $data;

        //         SELECT prod_id, brand_id, modal_id, product_name, billing_name, product_price, 
//         offer_price, offer_type, offer_details, arrival_status, stock_status, 
//         redirect_url, product_img, img_1, img_2, img_3, img_4, img_5, img_6, 
//         img_7, img_8, img_9, img_10, prod_desc, 
//         hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
//         specifications, flag, 1 AS order_col
//  FROM tbl_products
//  WHERE flag = 1 AND `offer_type` =  0 AND `offer_details` <> 0
//  UNION ALL

        // get Offers
        $res['offers'] = $db->query("SELECT * FROM (
            SELECT prod_id, access_id AS brand_id, sub_access_id AS modal_id, product_name, 
                billing_name, product_price, offer_price, offer_type, offer_details, 
                arrival_status, stock_status, redirect_url, product_img, img_1, img_2, 
                img_3, img_4, img_5, img_6, img_7, img_8, img_9, img_10, prod_desc, hot_sale, tbl_name, 
                search_brand, weight, weight_units, quantity, specifications, flag, 2 AS order_col
            FROM tbl_accessories_list
            WHERE flag = 1 AND offer_type = 0 AND offer_details <> 0

            UNION ALL

            SELECT prod_id, r_menu_id AS brand_id, r_sub_id AS modal_id, product_name, 
                billing_name, product_price, offer_price, offer_type, offer_details, 
                arrival_status, stock_status, redirect_url, product_img, img_1, img_2, img_3, 
                img_4, img_5, img_6, img_7, img_8, img_9, img_10, prod_desc, hot_sale, tbl_name, 
                search_brand, weight, weight_units, quantity, specifications, flag, 3 AS order_col
            FROM tbl_rproduct_list
            WHERE flag = 1 AND offer_type = 0 AND offer_details <> 0

            UNION ALL

            SELECT prod_id, h_menu_id AS brand_id, h_submenu_id AS modal_id, product_name, 
                billing_name, product_price, offer_price, offer_type, offer_details, arrival_status, 
                stock_status, redirect_url, product_img, img_1, img_2, img_3, img_4, img_5, img_6, 
                img_7, img_8, img_9, img_10, prod_desc, hot_sale, tbl_name, search_brand, weight, 
                weight_units, quantity, specifications, flag, 4 AS order_col
            FROM tbl_helmet_products
            WHERE flag = 1 AND offer_type = 0 AND offer_details <> 0

            UNION ALL

            SELECT prod_id, lug_menu_id AS brand_id, lug_submenu_id AS modal_id, product_name, 
                billing_name, product_price, offer_price, offer_type, offer_details, arrival_status, 
                stock_status, redirect_url, product_img, img_1, img_2, img_3, img_4, img_5, img_6, 
                img_7, img_8, img_9, img_10, prod_desc, hot_sale, tbl_name, search_brand, weight, 
                weight_units, quantity, specifications, flag, 5 AS order_col
            FROM tbl_luggagee_products
            WHERE flag = 1 AND offer_type = 0 AND offer_details <> 0

            UNION ALL

            SELECT prod_id, camp_menu_id AS brand_id, c_submenu_id AS modal_id, product_name, 
                billing_name, product_price, offer_price, offer_type, offer_details, arrival_status, 
                stock_status, redirect_url, product_img, img_1, img_2, img_3, img_4, img_5, img_6, 
                img_7, img_8, img_9, img_10, prod_desc, hot_sale, tbl_name, search_brand, weight, 
                weight_units, quantity, specifications, flag, 6 AS order_col
            FROM tbl_camping_products
            WHERE flag = 1 AND offer_type = 0 AND offer_details <> 0
        ) AS combined_offers
        ORDER BY order_col, prod_id
        LIMIT 9")->getResultArray();

        // Recently viewed products START
        $recentQry = "SELECT * FROM `frequent_products` WHERE `flag` = 1 AND `user` = ? 
GROUP BY `product_id` HAVING SUM(`prod_count`)<=10";

        $recentProducts = $db->query($recentQry, [$userID])->getResultArray();


        $recent = [];
        for ($i = 0; $i < count($recentProducts); $i++) {
            $tableName = $recentProducts[$i]['tbl_name'];
            $prodID = $recentProducts[$i]['product_id'];


            $query = "SELECT * FROM $tableName WHERE prod_id = ? AND flag = 1";
            $getProducts = $db->query($query, [$prodID])->getResultArray();

            $recent = array_merge($recent, $getProducts);
        }

        $res['recent_products'] = $recent;


        // Recently viewed products END 


        $res['helemt_filter_view'] = $db->query('SELECT * FROM `tbl_helmet_submenu` WHERE `flag` = 1 AND `h_menu_id` = 2')->getResultArray();


        $res['meta_title'] = "Top Quality Riding Gear & Accessories in India | Adventure Shoppe";
        $res['meta_description'] = "Shop top-quality riding gear and bike accessories in India at Adventure Shoppe. Find helmets, jackets, gloves & more for a safe and stylish ride.";


        return view('index', $res);
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

    public function detail($segName, $prodID)
    {

        $pID = base64_decode($prodID);

        $db = \Config\Database::connect();
        $res = $this->headerlist();


        // product Details Start
        $query1 = "SELECT * FROM tbl_products WHERE flag = 1 AND prod_id = ?";
        $res['products'] = $db->query($query1, $pID)->getResultArray();

        $tableName = "tbl_products";
        $query2 = "SELECT * FROM `tbl_configuration` WHERE prod_id = ? AND tbl_name = ? AND flag =1";
        $res["config"] = $db->query($query2, [$pID, $tableName])->getResultArray();

        if ($res["config"] == "") {
            $configDetails[] = "";
            $config['details'] = $configDetails;

        } else {
            $size = json_decode($res["config"][0]['size']);
            $color = json_decode($res["config"][0]['colour']);
            $stock = json_decode($res["config"][0]['soldout_status']);
            $configImg1 = json_decode($res["config"][0]['config_img1']);
            $configImg2 = json_decode($res["config"][0]['config_img2']);
            $configImg3 = json_decode($res["config"][0]['config_img3']);
            $configImg4 = json_decode($res["config"][0]['config_img4']);

            $configDetails[] = [
                'size' => $size,
                'color' => $color,
                'stock' => $stock,
                'configImg1' => $configImg1,
                'configImg2' => $configImg2,
                'configImg3' => $configImg3,
                'configImg4' => $configImg4,

            ];

            $config['details'] = $configDetails;

        }

        $res['colors']['colormaster'] = $db->query("SELECT `color_id`,`color_name`,`hex_code` FROM `tbl_color` WHERE `flag` = 1")->getResultArray();

        $res["product"] = array_merge($res['products'][0], $config['details'][0], $res['colors']);


        // to get similar products
        $product = $res['product'];
        $res['similarProducts'] = $this->getSimilarProducts($product, 0.5, 5);


        $res['tbl_name'] = "tbl_products";
        // to get cart count 
        $userID = session()->get('user_id');
        $query = "SELECT * FROM tbl_user_cart WHERE user_id = ?  AND flag =1";
        $usercount = $db->query($query, [$userID])->getResultArray();
        if ($usercount > 0) {
            $res['cart_count'] = sizeof($usercount);

        } else {
            $res['cart_count'] = 0;
        }

        // to get wishlist count 
        $res['wishlist_count'] = $this->getWishlistCount();

        return view('detail', $res);
    }
    private function getSimilarProducts($product, $priceRange = 0.5, $limit = 5)
    {
        $db = \Config\Database::connect();
        $brand_id = $product[0]['brand_id'];
        $modal_id = $product[0]['modal_id'];
        $prod_id = $product[0]['prod_id'];

        $offer_price = $product[0]['offer_price'];

        // Calculate the price range
        $lowerBound = $offer_price - ($offer_price * $priceRange);
        $upperBound = $offer_price + ($offer_price * $priceRange);

        $query = "SELECT DISTINCT a.modal_name AS modal, b.*
        FROM tbl_modal_master AS a 
        INNER JOIN tbl_products AS b ON a.modal_id = b.modal_id
        WHERE (b.modal_id = ? OR b.brand_id = ?) AND b.prod_id != ? AND b.flag = 1
        AND b.offer_price BETWEEN ? AND ? 
        ORDER BY RAND()
        LIMIT ?";

        return $db->query($query, [$modal_id, $brand_id, $prod_id, $lowerBound, $upperBound, $limit])->getResultArray();
    }


    public function loadmoreShopbyBike()
    {
        $db = \Config\Database::connect();
        $page = $this->request->getPost('page');
        $modalID = $this->request->getPost('subID');


        // Pagination Settings

        // Fetch common products based on modalID Count
        $res['common_prod_count'] = $db->query("SELECT * FROM `tbl_common_accessories` 
          WHERE FIND_IN_SET('$modalID', `modal_name`) > 0 
          AND `flag` = 1")
            ->getResultArray();


        $getCommonCount = $db->query("SELECT * FROM tbl_common_accessories 
              WHERE `modal_name` = 0 AND flag = 1")
            ->getResultArray();


        // Pagination Settings
        $perPage = 20;
        // Count total number of products for pagination
        $totalRows = count($res['common_prod_count']) + count($getCommonCount);
        $totalPages = ceil($totalRows / $perPage);
        $currentPage = $this->request->getVar('page') ?? 1;
        $offset = ($currentPage - 1) * $perPage;


        $res['common_prod'] = $db->query("
      SELECT * FROM `tbl_common_accessories` 
      WHERE FIND_IN_SET('$modalID', `modal_name`) > 0 
      AND `flag` = 1
  ")->getResultArray();

        $product = [];
        if (!empty($res['common_prod'])) {
            // Loop through each common product
            foreach ($res['common_prod'] as $commonProduct) {
                $prodID = $commonProduct['prod_id'];

                if ($modalID != 0) {
                    $query = "SELECT a.modal_name AS modal, b.*   
                      FROM tbl_modal_master AS a 
                      LEFT JOIN tbl_accessories_list AS b 
                      ON a.modal_id = ? 
                      WHERE b.prod_id = ? AND b.flag = 1 AND a.modal_id = ? ORDER BY b.product_name ASC
                  ";

                    $productDetails = $db->query($query, [$modalID, $prodID, $modalID])->getRow();
                    if ($productDetails) {
                        $product[] = $productDetails;
                    }
                }
            }
        }


        $res['sub_id'] = $modalID;

        // Fetch products where modal_name is 0
        $getQry = "SELECT * FROM tbl_common_accessories 
  WHERE `modal_name` = 0 AND flag = 1";
        $getCommon = $db->query($getQry)
            ->getResultArray();

        foreach ($getCommon as $common) {
            $ProdID = $common['prod_id'];
            $query = "SELECT NULL AS modal, b.* 
  FROM tbl_accessories_list AS b 
  WHERE b.flag = 1 AND b.prod_id = ?;";

            $productDetails = $db->query($query, [$ProdID])->getRow();
            if ($productDetails) {
                $product[] = $productDetails;
            }
        }

        if (!empty($product)) {
            $productNames = array_column($product, 'product_name');
            array_multisort($productNames, SORT_ASC, $product);
        }

        $res['product'] = array_slice($product, $offset, $perPage);

        // to get cart count 
        $userID = session()->get('user_id');
        $query = "SELECT * FROM tbl_user_cart WHERE user_id = ?  AND flag =1";
        $usercount = $db->query($query, [$userID])->getResultArray();
        if ($usercount > 0) {
            $res['cart_count'] = sizeof($usercount);

        } else {
            $res['cart_count'] = 0;
        }


        // to get wishlist count 
        $res['wishlist_count'] = $this->getWishlistCount();
        // Calculate Visible Page Links
        $maxVisibleLinks = 5; // Number of page links visible at a time
        $paginationLinks = [];

        $startPage = max(1, $page - floor($maxVisibleLinks / 2));
        $endPage = min($totalPages, $startPage + $maxVisibleLinks - 1);

        if ($startPage > 1) {
            $paginationLinks[] = [
                'label' => '<<',
                'page' => 1
            ];
        }

        if ($page > 1) {
            $paginationLinks[] = [
                'label' => 'Prev',
                'page' => $page - 1
            ];
        }

        for ($i = $startPage; $i <= $endPage; $i++) {
            $paginationLinks[] = [
                'label' => $i,
                'page' => $i,
                'active' => ($i == $page)
            ];
        }

        if ($page < $totalPages) {
            $paginationLinks[] = [
                'label' => 'Next',
                'page' => $page + 1
            ];
        }

        if ($endPage < $totalPages) {
            $paginationLinks[] = [
                'label' => '>>',
                'page' => $totalPages
            ];
        }


        echo json_encode($res = ([
            'products' => $res['product'],
            'pagination' => $paginationLinks
        ]));


    }

    public function products($segID2, $segID, $brandid, $page_number)
    {

        $modalID = base64_decode($segID);
        $page = is_numeric($page_number) ? (int) $page_number : 1;

        $segment = ucwords(str_replace('-', ' ', $segID2));
        $brandID = base64_decode($brandid);

        $db = \Config\Database::connect();
        $res = $this->headerlist();

        // Fetch common products based on modalID Count
        $res['common_prod_count'] = $db->query("SELECT * FROM `tbl_common_accessories` 
        WHERE FIND_IN_SET('$modalID', `modal_name`) > 0 
        AND `flag` = 1")
            ->getResultArray();


        $getCommonCount = $db->query("SELECT * FROM tbl_common_accessories 
            WHERE `modal_name` = 0 AND flag = 1")
            ->getResultArray();


        // Pagination Settings
        $perPage = 20;
        // Count total number of products for pagination
        $totalRows = count($res['common_prod_count']) + count($getCommonCount);
        $totalPages = ceil($totalRows / $perPage);
        $currentPage = $page ? $page : ($this->request->getVar('page') ? $this->request->getVar('page') : 1);
        $offset = ($currentPage - 1) * $perPage;


        $res['common_prod'] = $db->query("SELECT * FROM `tbl_common_accessories` 
            WHERE FIND_IN_SET('$modalID', `modal_name`) > 0 
            AND `flag` = 1
        ")->getResultArray();


        $product = [];
        if (!empty($res['common_prod'])) {
            // Loop through each common product
            foreach ($res['common_prod'] as $commonProduct) {
                $prodID = $commonProduct['prod_id'];

                if ($modalID != 0) {
                    $query = "SELECT a.modal_name AS modal, b.*   
                    FROM tbl_modal_master AS a 
                    LEFT JOIN tbl_accessories_list AS b 
                    ON a.modal_id = ? 
                    WHERE b.prod_id = ? AND b.flag = 1 AND a.modal_id = ? ORDER BY b.product_name ASC
                ";

                    $productDetails = $db->query($query, [$modalID, $prodID, $modalID])->getRow();
                    if ($productDetails) {
                        $product[] = $productDetails;
                    }
                }
            }
        }


        $res['segment'] = $segID2;

        $res['sub_id'] = $modalID;
        $res['brand_id'] = $brandID;

        // Fetch products where modal_name is 0
        $getQry = "SELECT * FROM tbl_common_accessories 
                    WHERE `modal_name` = 0 AND `brand_name` = 0 AND flag = 1";
        $getCommon = $db->query($getQry)->getResultArray();

        // Fetch Product where brandID  with All models data
        $getQry = "SELECT * FROM tbl_common_accessories 
        WHERE `modal_name` = 0 AND `brand_name` = ?   AND flag = 1";
        $getAllModeldata = $db->query($getQry, [$brandID])->getResultArray();



        foreach ($getCommon as $common) {
            $ProdID = $common['prod_id'];
            $query = "SELECT NULL AS modal, b.* 
                        FROM tbl_accessories_list AS b 
                        WHERE b.flag = 1 AND b.prod_id = ?;";

            $productDetails = $db->query($query, [$ProdID])->getRow();

            if ($productDetails) {
                $product[] = $productDetails;
            }
        }


        foreach ($getAllModeldata as $allmodel) {
            $ProdID = $allmodel['prod_id'];
            $query = "SELECT NULL AS modal, b.* 
                        FROM tbl_accessories_list AS b 
                        WHERE b.flag = 1 AND b.prod_id = ?";

            $productDetails = $db->query($query, [$ProdID])->getRow();
            if ($productDetails) {
                $product[] = $productDetails;
            }
        }

        if (!empty($product)) {
            $productNames = array_column($product, 'product_name');
            array_multisort($productNames, SORT_ASC, $product);
        }

        $res['product'] = array_slice($product, $offset, $perPage);


        // to get cart count 
        $userID = session()->get('user_id');
        $query = "SELECT * FROM tbl_user_cart WHERE user_id = ?  AND flag =1";
        $usercount = $db->query($query, [$userID])->getResultArray();
        if ($usercount > 0) {
            $res['cart_count'] = sizeof($usercount);

        } else {
            $res['cart_count'] = 0;
        }


        // to get wishlist count 
        $res['wishlist_count'] = $this->getWishlistCount();

        // Get Product Search Filter data
        $searchBrandArr = [];
        $modalquery = "";

        $q1 = "SELECT prod_id 
        FROM tbl_common_accessories 
        WHERE (`modal_name` LIKE CONCAT('%', ?, '%') OR `modal_name` = '0') 
        AND `flag` = 1;
        ";
        $getProdList = $db->query($q1, [$modalID])->getResultArray();


        for ($i = 0; $i < count($getProdList); $i++) {
            $accessProdID = $getProdList[$i]['prod_id'];

            $searchQry = "SELECT DISTINCT a.search_brand, b.`brand_name`
                  FROM tbl_accessories_list AS a
                  INNER JOIN brand_master AS b
                  ON a.search_brand = b.brand_master_id
                  WHERE a.flag = 1 AND b.flag = 1 AND a.prod_id = ?";


            $result = $db->query($searchQry, [$accessProdID])->getResultArray();
            foreach ($result as $row) {
                $searchBrandArr[] = $row;
            }
        }

        $searchBrandArr = array_map("unserialize", array_unique(array_map("serialize", $searchBrandArr)));

        // Sort by brand_name while ignoring case
        usort($searchBrandArr, function ($a, $b) {
            return strcasecmp($a['brand_name'], $b['brand_name']);
        });

        $res['search_brand'] = array_values($searchBrandArr);


        $maxVisibleLinks = 5;
        $paginationLinks = [];

        $startPage = max(1, $page - floor($maxVisibleLinks / 2));
        $endPage = min($totalPages, $startPage + $maxVisibleLinks - 1);

        if ($startPage > 1) {
            $paginationLinks[] = [
                'label' => '<<',
                'page' => 1
            ];
        }

        if ($page > 1) {
            $paginationLinks[] = [
                'label' => 'Prev',
                'page' => $page - 1
            ];
        }

        for ($i = $startPage; $i <= $endPage; $i++) {
            $paginationLinks[] = [
                'label' => $i,
                'page' => $i,
                'active' => ($i == $page)
            ];
        }

        if ($page < $totalPages) {
            $paginationLinks[] = [
                'label' => 'Next',
                'page' => $page + 1
            ];
        }

        if ($endPage < $totalPages) {
            $paginationLinks[] = [
                'label' => '>>',
                'page' => $totalPages
            ];
        }

        $res['pagination'] = $paginationLinks;
        $res['total_products'] = $totalRows;
        $res['segment_modal'] = $segment;

        $res['meta_title'] = "All Brand Bike Accessories in Coimbatore | Branded Bike Gear in Tamilnadu";
        $res['meta_description'] = "Adventure Shoppe offers Multi Brand Bike Accessories in Coimbatore and Tamilnadu. Explore premium riding gear and parts from top motorcycle brands.";

        return view('products', $res);
    }
    public function cartdetails(): string
    {
        $db = \Config\Database::connect();
        $res = $this->headerlist();

        // to get cart count 
        $userID = session()->get('user_id');
        $query = "SELECT * FROM tbl_user_cart WHERE user_id = ?  AND flag =1";
        $usercount = $db->query($query, [$userID])->getResultArray();
        if ($usercount > 0) {
            $res['cart_count'] = sizeof($usercount);

        } else {
            $res['cart_count'] = 0;
        }
        // end cart count


        // to get wishlist count 
        $res['wishlist_count'] = $this->getWishlistCount();

        return view('addcart', $res);
    }
    public function shopbybrand($segName): string
    {
        $segment = ucwords(str_replace('-', ' ', $segName));

        $db = \Config\Database::connect();
        $res = $this->headerlist();

        // end Header 


        $res['modal_list'] = $db->query(
            "SELECT  a.`modal_name`,a.`modal_img`,a.`modal_id`, b.`brand_name`,b.`brand_id` FROM `tbl_modal_master` AS a 
             INNER JOIN tbl_brand_master AS b ON  a.`brand_id` = b.brand_id
             WHERE a.`flag` = 1 AND b.brand_name = '$segment';"
        )->getResultArray();


        // to get cart count 
        $userID = session()->get('user_id');
        $query = "SELECT * FROM tbl_user_cart WHERE user_id = ?  AND flag =1";
        $usercount = $db->query($query, [$userID])->getResultArray();


        if ($usercount > 0) {
            $res['cart_count'] = sizeof($usercount);

        } else if ($usercount == "" || $usercount == 0) {
            $res['cart_count'] = 0;
        }
        // end cart count


        // to get wishlist count 
        $res['wishlist_count'] = $this->getWishlistCount();

        $res['meta_title'] = "All Brand Bike Accessories in Coimbatore | Branded Bike Gear in Tamilnadu";
        $res['meta_description'] = "Adventure Shoppe offers Multi Brand Bike Accessories in Coimbatore and Tamilnadu. Explore premium riding gear and parts from top motorcycle brands.";

        return view('shopbybrand', $res);
    }
    public function accessories($segName, $subaccID, $page_number)
    {

        $subID = base64_decode($subaccID);
        $page = is_numeric($page_number) ? (int) $page_number : 1;



        $segment = strtolower(str_replace('-', ' ', $segName));


        $db = \Config\Database::connect();
        $res = $this->headerlist();

        // Pagination Settings
        $perPage = 12;
        // Count total number of products for pagination
        $totalRows = $db->query("SELECT COUNT(*) AS total FROM tbl_accessories_list WHERE sub_access_id = ? AND flag = 1", [$subID])->getRow()->total;



        $totalPages = ceil($totalRows / $perPage);
        $currentPage = $page ? $page : ($this->request->getVar('page') ? $this->request->getVar('page') : 1);
        $offset = ($currentPage - 1) * $perPage;

        $res['access_list'] = $db->query(
            "SELECT a.*, b.sub_access_name
             FROM tbl_accessories_list AS a 
             INNER JOIN tbl_subaccess_master AS b 
             ON a.sub_access_id = b.sub_access_id 
             WHERE b.sub_access_id = ? AND a.flag = 1
             ORDER BY a.product_name ASC 
             LIMIT ? OFFSET ?",
            [$subID, $perPage, $offset]
        )->getResultArray();

        $res['sub_id'] = $subID;


        $res['segment'] = $segName;
        // to get cart count 
        $userID = session()->get('user_id');
        $query = "SELECT * FROM tbl_user_cart WHERE user_id = ?  AND flag =1";
        $usercount = $db->query($query, [$userID])->getResultArray();
        if ($usercount > 0) {
            $res['cart_count'] = sizeof($usercount);

        } else {
            $res['cart_count'] = 0;
        }
        // end cart count

        // to get wishlist count 
        $res['wishlist_count'] = $this->getWishlistCount();

        $searchQry = "SELECT DISTINCT a.search_brand , b.`brand_name`
        FROM tbl_accessories_list AS a INNER JOIN brand_master AS b 
        ON a.search_brand = b.brand_master_id
        WHERE a.flag= 1 AND b.flag = 1 AND `sub_access_id` = ?";
        $res['search_brand'] = $db->query($searchQry, [$subID])->getResultArray();

        // Calculate Visible Page Links
        $maxVisibleLinks = 5; // Number of page links visible at a time
        $paginationLinks = [];

        $startPage = max(1, $page - floor($maxVisibleLinks / 2));
        $endPage = min($totalPages, $startPage + $maxVisibleLinks - 1);

        if ($startPage > 1) {
            $paginationLinks[] = [
                'label' => '<<',
                'page' => 1
            ];
        }

        if ($page > 1) {
            $paginationLinks[] = [
                'label' => 'Prev',
                'page' => $page - 1
            ];
        }

        for ($i = $startPage; $i <= $endPage; $i++) {
            $paginationLinks[] = [
                'label' => $i,
                'page' => $i,
                'active' => ($i == $page)
            ];
        }

        if ($page < $totalPages) {
            $paginationLinks[] = [
                'label' => 'Next',
                'page' => $page + 1
            ];
        }

        if ($endPage < $totalPages) {
            $paginationLinks[] = [
                'label' => '>>',
                'page' => $totalPages
            ];
        }

        $res['pagination'] = $paginationLinks;
        $res['total_products'] = $totalRows;

        $res['meta_title'] = "Bike Performance Accessories in Coimbatore | Superbike Parts Tamilnadu";
        $res['meta_description'] = "Adventure Shoppe offers superbike parts & performance gear in Coimbatore, Tamilnadu. Upgrade your ride with trusted brands.";

        return view('motorAccessories', $res);
    }


    public function accessoriesDetail($segName, $proID)
    {
        $prodID = base64_decode($proID);
        $segment = strtolower(str_replace('-', ' ', $segName));
        $db = \Config\Database::connect();
        $res = $this->headerlist();

        // to get cart count 
        $userID = session()->get('user_id');
        $query = "SELECT * FROM tbl_user_cart WHERE user_id = ?  AND flag =1";
        $usercount = $db->query($query, [$userID])->getResultArray();
        if ($usercount > 0) {
            $res['cart_count'] = sizeof($usercount);

        } else {
            $res['cart_count'] = 0;
        }
        // end cart count

        // to get wishlist count 
        $res['wishlist_count'] = $this->getWishlistCount();


        // Product Details start
        $query1 = "SELECT * FROM tbl_accessories_list WHERE flag = 1 AND prod_id = ?";
        $res['product'] = $db->query($query1, $prodID)->getResultArray();


        $tableName = "tbl_accessories_list";
        $query2 = "SELECT * FROM `tbl_configuration` WHERE prod_id = ? AND tbl_name = ? AND flag =1";
        $res["config"] = $db->query($query2, [$prodID, $tableName])->getResultArray();

        $configDetails = [];
        if ($res["config"][0]["size"] == "" || $res["config"][0]["size"] == 'null') {
            $configDetails[] = [
                'size' => "",
                'soldout_status' => ''
            ];
            $config['details'] = $configDetails;
            $res["acc_details"] = array_merge($res['product'][0], $config['details'][0]);

        } else {
            $size = json_decode($res["config"][0]['size']);
            $stock = json_decode($res["config"][0]['soldout_status']);
            if ($size != "") {
                // Prepare arrays for display
                $filtrSize = $size;
                $sizeArray = [];

                $configDetails[] = [
                    'size' => $filtrSize,
                    'stock' => $stock,
                ];
                $config['details'] = $configDetails;
                $res["acc_details"] = array_merge($res['product'][0], $config['details'][0]);
            }
            if ($config['details'][0] != "") {
                $res["acc_details"] = array_merge($res['product'][0], $config['details'][0]);
            } else {
                echo "5";
                $configDetails[] = [
                    'size' => "",
                    'stock' => "",
                ];

                $config['details'] = $configDetails;
                $res["acc_details"] = $configDetails;
            }
        }
        // Product Details end 

        // to get similar products
        $product = $res['product'];




        $res['similarProducts'] = $this->getSimilarAccessories($product, 0.5, 5);




        $res['tbl_name'] = "tbl_accessories_list";
        $res['current_url'] = current_url();

        $res['user_idd'] = $userID;

        // Recently viewed products START
        $recentQry = "SELECT * FROM `frequent_products` WHERE `flag` = 1 AND `user` = ? 
         GROUP BY `product_id` HAVING SUM(`prod_count`)<=10";

        $recentProducts = $db->query($recentQry, [$userID])->getResultArray();


        $recent = [];
        for ($i = 0; $i < count($recentProducts); $i++) {
            $tableName = $recentProducts[$i]['tbl_name'];
            $prodID = $recentProducts[$i]['product_id'];


            $query = "SELECT * FROM $tableName WHERE prod_id = ? AND flag = 1";
            $getProducts = $db->query($query, [$prodID])->getResultArray();

            $recent = array_merge($recent, $getProducts);
        }

        $res['recent_products'] = $recent;
        // Recently viewed products END 


        /* SIMILAR PRODUCTS NEW */
        $subMenu = $res["acc_details"]['sub_access_id'];
        $PRODID = $res["acc_details"]['prod_id'];

        $q1 = "SELECT DISTINCT * FROM `tbl_accessories_list` WHERE `flag` = 1 AND `sub_access_id` = ?  AND `flag` = 1 AND prod_id <> ?";
        $res['similar'] = $db->query($q1, [$subMenu, $PRODID])->getResultArray();
        /* SIMILAR PRODUCTS NEW   END*/

        $res['meta_title'] = "Bike Performance Accessories in Coimbatore | Superbike Parts Tamilnadu";
        $res['meta_description'] = "Adventure Shoppe offers superbike parts & performance gear in Coimbatore, Tamilnadu. Upgrade your ride with trusted brands.";


        return view('accessoriesDetail', $res);
    }

    private function getSimilarAccessories($product, $priceRange = 0.5, $limit = 5)
    {
        $db = \Config\Database::connect();
        $access_id = $product[0]['access_id'];
        $sub_access_id = $product[0]['sub_access_id'];
        $prod_id = $product[0]['prod_id'];

        $offer_price = $product[0]['offer_price'];

        // Calculate the price range
        $lowerBound = $offer_price - ($offer_price * $priceRange);
        $upperBound = $offer_price + ($offer_price * $priceRange);

        $query = "SELECT DISTINCT a.access_title AS modal, b.*
        FROM tbl_access_master AS a 
        INNER JOIN tbl_accessories_list AS b ON a.access_id = b.access_id
        WHERE (b.access_id = ? OR b.sub_access_id = ?) AND b.prod_id != ? AND b.flag = 1
        AND b.offer_price BETWEEN ? AND ? 
        ORDER BY RAND()
        LIMIT ?";

        return $db->query($query, [$access_id, $sub_access_id, $prod_id, $lowerBound, $upperBound, $limit])->getResultArray();
    }



    public function ridingAccessories($segName, $sID, $page_number)
    {

        $subID = base64_decode($sID);
        $page = is_numeric($page_number) ? (int) $page_number : 1;

        $segment = strtolower(str_replace('-', ' ', $segName));

        $res = $this->headerlist();

        // Pagination Settings
        $perPage = 12;
        // Count total number of products for pagination
        $totalRows = $this->db->query("SELECT COUNT(*) AS total FROM tbl_rproduct_list WHERE r_sub_id = ? AND flag = 1", [$subID])->getRow()->total;

        $totalPages = ceil($totalRows / $perPage);
        $currentPage = $page ? $page : ($this->request->getVar('page') ? $this->request->getVar('page') : 1);
        $offset = ($currentPage - 1) * $perPage;

        $res['r_accessories'] = $this->db->query("SELECT a.r_sub_menu, b.* FROM tbl_riding_submenu AS a 
        INNER JOIN tbl_rproduct_list AS b ON a.r_sub_id = b.r_sub_id
        WHERE b.r_sub_id = ? AND b.flag = 1 
        ORDER BY b.product_name ASC 
        LIMIT ? OFFSET ?", [$subID, $perPage, $offset])->getResultArray();

        // to get cart count 
        $userID = session()->get('user_id');
        $query = "SELECT * FROM tbl_user_cart WHERE user_id = ? AND flag =1";
        $usercount = $this->db->query($query, [$userID])->getResultArray();
        if ($usercount > 0) {
            $res['cart_count'] = sizeof($usercount);

        } else {
            $res['cart_count'] = 0;
        }
        // end cart count

        // to get wishlist count 
        $res['wishlist_count'] = $this->getWishlistCount();

        // get Product Seacrh Filter data 
        $searchquery = "SELECT DISTINCT a.search_brand , b.`brand_name`
          FROM tbl_rproduct_list AS a INNER JOIN brand_master AS b 
          ON a.search_brand = b.brand_master_id
          WHERE a.flag= 1 AND a.r_sub_id = ? AND b.flag = 1";
        $res['search_brand'] = $this->db->query($searchquery, [$subID])->getResultArray();

        $res['sub_id'] = $subID;
        $res['segment'] = $segName;

        // Calculate Visible Page Links
        $maxVisibleLinks = 5; // Number of page links visible at a time
        $paginationLinks = [];

        $startPage = max(1, $page - floor($maxVisibleLinks / 2));
        $endPage = min($totalPages, $startPage + $maxVisibleLinks - 1);

        if ($startPage > 1) {
            $paginationLinks[] = [
                'label' => '<<',
                'page' => 1
            ];
        }

        if ($page > 1) {
            $paginationLinks[] = [
                'label' => 'Prev',
                'page' => $page - 1
            ];
        }

        for ($i = $startPage; $i <= $endPage; $i++) {
            $paginationLinks[] = [
                'label' => $i,
                'page' => $i,
                'active' => ($i == $page)
            ];
        }

        if ($page < $totalPages) {
            $paginationLinks[] = [
                'label' => 'Next',
                'page' => $page + 1
            ];
        }

        if ($endPage < $totalPages) {
            $paginationLinks[] = [
                'label' => '>>',
                'page' => $totalPages
            ];
        }

        $res['pagination'] = $paginationLinks;
        $res['total_products'] = $totalRows;

        $res['meta_title'] = "Best Riding Gear Shop in Coimbatore | Riding Gear in Tamilnadu";
        $res['meta_description'] = "Adventure Shoppe is a leading riding equipments shop in Coimbatore and Tamilnadu, offering premium motorcycle gear, helmets, and accessories for all riders.";
        return view('ridingAccessories', $res);
    }

    public function loadmoreRidingDetails()
    {
        $db = \Config\Database::connect();
        $page = $this->request->getPost('page');
        $subID = $this->request->getPost('subID');

        $session = \Config\Services::session();



        $currecnt_page = $session->set('current_page', $page);


        // Pagination Settings
        $perPage = 12;
        // Count total number of products for pagination
        $totalRows = $db->query("SELECT COUNT(*) AS total FROM tbl_rproduct_list WHERE r_sub_id = ? AND flag = 1", [$subID])->getRow()->total;
        $totalPages = ceil($totalRows / $perPage);
        $currentPage = $page ?? 1;
        $offset = ($currentPage - 1) * $perPage;

        $res['r_accessories'] = $db->query("SELECT a.r_sub_menu, b.* FROM tbl_riding_submenu AS a 
         INNER JOIN tbl_rproduct_list AS b ON a.r_sub_id = b.r_sub_id
         WHERE b.r_sub_id = ? AND b.flag = 1 
         ORDER BY b.product_name ASC 
         LIMIT ? OFFSET ?", [$subID, $perPage, $offset])->getResultArray();


        // Calculate Visible Page Links
        $maxVisibleLinks = 5;
        $paginationLinks = [];

        $startPage = max(1, $page - floor($maxVisibleLinks / 2));
        $endPage = min($totalPages, $startPage + $maxVisibleLinks - 1);

        if ($startPage > 1) {
            $paginationLinks[] = [
                'label' => '<<',
                'page' => 1
            ];
        }

        if ($page > 1) {
            $paginationLinks[] = [
                'label' => 'Prev',
                'page' => $page - 1
            ];
        }

        for ($i = $startPage; $i <= $endPage; $i++) {
            $paginationLinks[] = [
                'label' => $i,
                'page' => $i,
                'active' => ($i == $page)
            ];
        }

        if ($page < $totalPages) {
            $paginationLinks[] = [
                'label' => 'Next',
                'page' => $page + 1
            ];
        }

        if ($endPage < $totalPages) {
            $paginationLinks[] = [
                'label' => '>>',
                'page' => $totalPages
            ];
        }




        $res = ([
            'products' => $res['r_accessories'],
            'pagination' => $paginationLinks
        ]);



        echo json_encode($res);

    }


    public function loadmoreHDetails()
    {
        $db = \Config\Database::connect();

        $page = $this->request->getPost('page');
        $subID = $this->request->getPost('subID');

        $pager = \Config\Services::pager();

        // Pagination Settings
        $perPage = 12;
        // Count total number of products for pagination
        $totalRows = $db->query("SELECT COUNT(*) AS total FROM tbl_helmet_products WHERE h_submenu_id = ? AND flag = 1", [$subID])->getRow()->total;
        $totalPages = ceil($totalRows / $perPage);
        $currentPage = $page ?? 1;
        $offset = ($currentPage - 1) * $perPage;

        $res['h_accessories'] = $db->query(
            "SELECT a.h_submenu, b.* 
            FROM tbl_helmet_submenu AS a 
            INNER JOIN tbl_helmet_products AS b 
            ON a.h_submenu_id = b.h_submenu_id 
            WHERE a.h_submenu_id = ? AND b.flag = 1 
            ORDER BY b.product_name ASC 
            LIMIT $perPage OFFSET $offset",
            [$subID]
        )->getResultArray();


        // Calculate Visible Page Links
        $maxVisibleLinks = 5; // Number of page links visible at a time
        $paginationLinks = [];

        $startPage = max(1, $page - floor($maxVisibleLinks / 2));
        $endPage = min($totalPages, $startPage + $maxVisibleLinks - 1);

        if ($startPage > 1) {
            $paginationLinks[] = [
                'label' => '<<',
                'page' => 1
            ];
        }

        if ($page > 1) {
            $paginationLinks[] = [
                'label' => 'Prev',
                'page' => $page - 1
            ];
        }

        for ($i = $startPage; $i <= $endPage; $i++) {
            $paginationLinks[] = [
                'label' => $i,
                'page' => $i,
                'active' => ($i == $page)
            ];
        }

        if ($page < $totalPages) {
            $paginationLinks[] = [
                'label' => 'Next',
                'page' => $page + 1
            ];
        }

        if ($endPage < $totalPages) {
            $paginationLinks[] = [
                'label' => '>>',
                'page' => $totalPages
            ];
        }

        $res = ([
            'products' => $res['h_accessories'],
            'pagination' => $paginationLinks
        ]);


        echo json_encode($res);

    }
    public function loadmoreLugDetails()
    {
        $db = \Config\Database::connect();

        $pager = \Config\Services::pager();
        $page = $this->request->getPost('page');
        $subID = $this->request->getPost('subID');

        // Pagination Settings
        $perPage = 12;
        // Count total number of products for pagination
        $totalRows = $db->query("SELECT COUNT(*) AS total FROM tbl_luggagee_products WHERE lug_submenu_id = ? AND flag = 1", [$subID])->getRow()->total;
        $totalPages = ceil($totalRows / $perPage);
        $currentPage = $page ?? 1;
        $offset = ($currentPage - 1) * $perPage;



        $res['lug_accessories'] = $db->query(
            "SELECT a.lug_submenu, b.*
             FROM tbl_luggage_submenu AS a
             INNER JOIN tbl_luggagee_products AS b 
             ON a.lug_submenu_id = b.lug_submenu_id
             WHERE b.lug_submenu_id = ? AND b.flag = 1
             ORDER BY b.product_name ASC
             LIMIT ? OFFSET ?",
            [$subID, $perPage, $offset]
        )->getResultArray();



        // Calculate Visible Page Links
        $maxVisibleLinks = 5; // Number of page links visible at a time
        $paginationLinks = [];

        $startPage = max(1, $page - floor($maxVisibleLinks / 2));
        $endPage = min($totalPages, $startPage + $maxVisibleLinks - 1);

        if ($startPage > 1) {
            $paginationLinks[] = [
                'label' => '<<',
                'page' => 1
            ];
        }

        if ($page > 1) {
            $paginationLinks[] = [
                'label' => 'Prev',
                'page' => $page - 1
            ];
        }

        for ($i = $startPage; $i <= $endPage; $i++) {
            $paginationLinks[] = [
                'label' => $i,
                'page' => $i,
                'active' => ($i == $page)
            ];
        }

        if ($page < $totalPages) {
            $paginationLinks[] = [
                'label' => 'Next',
                'page' => $page + 1
            ];
        }

        if ($endPage < $totalPages) {
            $paginationLinks[] = [
                'label' => '>>',
                'page' => $totalPages
            ];
        }

        $res = ([
            'products' => $res['lug_accessories'],
            'pagination' => $paginationLinks
        ]);


        echo json_encode($res);
    }

    public function loadmoreCampDetails()
    {
        $db = \Config\Database::connect();

        $pager = \Config\Services::pager();
        $page = $this->request->getPost('page');
        $subID = $this->request->getPost('subID');

        // Pagination Settings
        $perPage = 12;
        // Count total number of products for pagination
        $totalRows = $db->query("SELECT COUNT(*) AS total FROM tbl_camping_products WHERE c_submenu_id = ? AND flag = 1", [$subID])->getRow()->total;
        $totalPages = ceil($totalRows / $perPage);
        $currentPage = $page ?? 1;
        $offset = ($currentPage - 1) * $perPage;

        $res['camp_products'] = $db->query(
            "SELECT a.c_submenu, b.* 
             FROM tbl_camping_submenu AS a 
             INNER JOIN tbl_camping_products AS b 
             ON a.c_submenu_id = b.c_submenu_id 
             WHERE b.flag = 1 AND a.c_submenu_id = ? 
             ORDER BY b.product_name ASC 
             LIMIT ? OFFSET ?",
            [$subID, $perPage, $offset]
        )->getResultArray();


        // Calculate Visible Page Links
        $maxVisibleLinks = 5; // Number of page links visible at a time
        $paginationLinks = [];

        $startPage = max(1, $page - floor($maxVisibleLinks / 2));
        $endPage = min($totalPages, $startPage + $maxVisibleLinks - 1);

        if ($startPage > 1) {
            $paginationLinks[] = [
                'label' => '<<',
                'page' => 1
            ];
        }

        if ($page > 1) {
            $paginationLinks[] = [
                'label' => 'Prev',
                'page' => $page - 1
            ];
        }

        for ($i = $startPage; $i <= $endPage; $i++) {
            $paginationLinks[] = [
                'label' => $i,
                'page' => $i,
                'active' => ($i == $page)
            ];
        }

        if ($page < $totalPages) {
            $paginationLinks[] = [
                'label' => 'Next',
                'page' => $page + 1
            ];
        }

        if ($endPage < $totalPages) {
            $paginationLinks[] = [
                'label' => '>>',
                'page' => $totalPages
            ];
        }

        $res = ([
            'products' => $res['camp_products'],
            'pagination' => $paginationLinks
        ]);




        echo json_encode($res);
    }

    public function loadmoreAccessDetails()
    {
        $db = \Config\Database::connect();

        $pager = \Config\Services::pager();
        $page = $this->request->getPost('page');
        $subID = $this->request->getPost('subID');

        // Pagination Settings
        $perPage = 12;
        // Count total number of products for pagination
        $totalRows = $db->query("SELECT COUNT(*) AS total FROM tbl_accessories_list WHERE sub_access_id = ? AND flag = 1", [$subID])->getRow()->total;
        $totalPages = ceil($totalRows / $perPage);
        $currentPage = $page ?? 1;
        $offset = ($currentPage - 1) * $perPage;

        $res['motor_access'] = $db->query(
            "SELECT a.*, b.sub_access_name
             FROM tbl_accessories_list AS a 
             INNER JOIN tbl_subaccess_master AS b 
             ON a.sub_access_id = b.sub_access_id 
             WHERE b.sub_access_id = ? AND a.flag =1  
             ORDER BY a.product_name ASC 
             LIMIT ? OFFSET ?",
            [$subID, $perPage, $offset]
        )->getResultArray();


        // Calculate Visible Page Links
        $maxVisibleLinks = 5; // Number of page links visible at a time
        $paginationLinks = [];

        $startPage = max(1, $page - floor($maxVisibleLinks / 2));
        $endPage = min($totalPages, $startPage + $maxVisibleLinks - 1);

        if ($startPage > 1) {
            $paginationLinks[] = [
                'label' => '<<',
                'page' => 1
            ];
        }

        if ($page > 1) {
            $paginationLinks[] = [
                'label' => 'Prev',
                'page' => $page - 1
            ];
        }

        for ($i = $startPage; $i <= $endPage; $i++) {
            $paginationLinks[] = [
                'label' => $i,
                'page' => $i,
                'active' => ($i == $page)
            ];
        }

        if ($page < $totalPages) {
            $paginationLinks[] = [
                'label' => 'Next',
                'page' => $page + 1
            ];
        }

        if ($endPage < $totalPages) {
            $paginationLinks[] = [
                'label' => '>>',
                'page' => $totalPages
            ];
        }

        $res = ([
            'products' => $res['motor_access'],
            'pagination' => $paginationLinks
        ]);

        echo json_encode($res);
    }



    public function ridingDetails($segName, $rID)
    {

        $segmentt = base64_decode($segName);
        $rID = base64_decode($rID);


        $db = \Config\Database::connect();
        $res = $this->headerlist();

        // Product Details start
        $query1 = "SELECT * FROM tbl_rproduct_list WHERE flag = 1 AND prod_id = ?";
        $res['product'] = $db->query($query1, $rID)->getResultArray();


        $tableName = "tbl_rproduct_list";
        $query2 = "SELECT * FROM `tbl_configuration` WHERE prod_id = ? AND tbl_name = ? AND flag =1";
        $res["config"] = $db->query($query2, [$rID, $tableName])->getResultArray();

        if ($res["config"][0]["size"] == "" || $res["config"][0]["size"] == 'null') {
            $configDetails[] = [
                'size' => "",
                'stock' => ""
            ];
            $config['details'] = $configDetails;
            $res["r_details"] = array_merge($res['product'][0], $config['details'][0]);

        } else {
            $size = json_decode($res["config"][0]['size']);
            $stock = json_decode($res["config"][0]['soldout_status']);
            if ($size != "") {
                // Prepare arrays for display
                $filtrSize = $size;
                $sizeArray = [];

                $configDetails[] = [
                    'size' => $filtrSize,
                    'stock' => $stock,
                ];
                $config['details'] = $configDetails;
                $res["r_details"] = array_merge($res['product'][0], $config['details'][0]);
            }
            if ($config['details'][0] != "") {
                $res["r_details"] = array_merge($res['product'][0], $config['details'][0]);
            } else {
                echo "5";
                $configDetails[] = [
                    'size' => "",
                    'stock' => "",
                ];

                $config['details'] = $configDetails;
                $res["r_details"] = $configDetails;
            }
        }


        // to get similar products
        $product = $res['product'];

        $res['similarProducts'] = $this->getSimilarRidingProducts($product, 0.5, 5);


        // to get cart count 
        $userID = session()->get('user_id');
        $query = "SELECT * FROM tbl_user_cart WHERE user_id = ? AND flag =1";
        $usercount = $db->query($query, [$userID])->getResultArray();
        if ($usercount > 0) {
            $res['cart_count'] = sizeof($usercount);

        } else {
            $res['cart_count'] = 0;
        }


        $res['tbl_name'] = "tbl_rproduct_list";

        $res['wishlist_count'] = $this->getWishlistCount();

        $res['current_url'] = current_url();
        $res['user_idd'] = $userID;

        // Recently viewed products START
        $recentQry = "SELECT * FROM `frequent_products` WHERE `flag` = 1 AND `user` = ? 
         GROUP BY `product_id` HAVING SUM(`prod_count`)<=10";

        $recentProducts = $db->query($recentQry, [$userID])->getResultArray();


        $recent = [];
        for ($i = 0; $i < count($recentProducts); $i++) {
            $tableName = $recentProducts[$i]['tbl_name'];
            $prodID = $recentProducts[$i]['product_id'];


            $query = "SELECT * FROM $tableName WHERE prod_id = ? AND flag = 1";
            $getProducts = $db->query($query, [$prodID])->getResultArray();

            $recent = array_merge($recent, $getProducts);
        }

        $res['recent_products'] = $recent;
        // Recently viewed products END 



        /* SIMILAR PRODUCTS NEW */
        $subMenu = $res["r_details"]['r_sub_id'];
        $PRODID = $res["r_details"]['prod_id'];

        $q1 = "SELECT DISTINCT * FROM `tbl_rproduct_list` WHERE `flag` = 1 AND `r_sub_id` = ?  AND `flag` = 1 AND prod_id <> ?";
        $res['similar'] = $db->query($q1, [$subMenu, $PRODID])->getResultArray();
        /* SIMILAR PRODUCTS NEW   END*/

        $res['meta_title'] = "Best Riding Gear Shop in Coimbatore | Riding Gear in Tamilnadu";
        $res['meta_description'] = "Adventure Shoppe is a leading riding equipments shop in Coimbatore and Tamilnadu, offering premium motorcycle gear, helmets, and accessories for all riders.";
        return view('ridingDetails', $res);
    }


    private function getSimilarRidingProducts($product, $priceRange = 0.5, $limit = 5)
    {
        $db = \Config\Database::connect();
        $r_menu_id = $product[0]['r_menu_id'];
        $r_sub_id = $product[0]['r_sub_id'];
        $prod_id = $product[0]['prod_id'];

        $offer_price = $product[0]['offer_price'];

        // Calculate the price range
        $lowerBound = $offer_price - ($offer_price * $priceRange);
        $upperBound = $offer_price + ($offer_price * $priceRange);

        $query = "SELECT DISTINCT a.r_menu AS modal, b.*
        FROM tbl_riding_menu AS a 
        INNER JOIN tbl_rproduct_list AS b ON a.r_menu_id = b.r_menu_id
        WHERE (b.r_menu_id = ? OR b.r_sub_id = ?) AND b.prod_id != ? AND b.flag = 1
        AND b.offer_price BETWEEN ? AND ? 
        ORDER BY RAND()
        LIMIT ?";

        $result = $db->query($query, [$r_menu_id, $r_sub_id, $prod_id, $lowerBound, $upperBound, $limit])->getResultArray();

        return $result;


    }




    public function touringAccessories($segName, $lugID, $page_number)
    {
        $db = \Config\Database::connect();

        $lugIDD = base64_decode($lugID);
        $page = is_numeric($page_number) ? (int) $page_number : 1;

        $segment = strtolower(str_replace('-', ' ', $segName));

        $res = $this->headerlist();

        // Pagination Settings
        $page = is_numeric($page_number) ? (int) $page_number : 1;
        $perPage = 12;
        // Count total number of products for pagination
        $totalRows = $db->query("SELECT COUNT(*) AS total FROM tbl_luggagee_products WHERE lug_submenu_id = ? AND flag = 1", [$lugIDD])->getRow()->total;

        $totalPages = ceil($totalRows / $perPage);
        $currentPage = $page ? $page : ($this->request->getVar('page') ? $this->request->getVar('page') : 1);
        $offset = ($currentPage - 1) * $perPage;

        $res['tour_access'] = $db->query(
            "SELECT a.lug_submenu, b.*
            FROM tbl_luggage_submenu AS a
            INNER JOIN tbl_luggagee_products AS b
            ON a.lug_submenu_id = b.lug_submenu_id
            WHERE b.lug_submenu_id = ? 
            AND b.flag = 1
            ORDER BY b.product_name ASC
            LIMIT ? OFFSET ?;",
            [$lugIDD, $perPage, $offset]
        )->getResultArray();


        $res['sub_id'] = $lugIDD;
        $res['segment'] = $segName;


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


        // to get wishlist count 
        $res['wishlist_count'] = $this->getWishlistCount();

        // get Product Seacrh Filter data 

        $searchQry = "SELECT DISTINCT a.search_brand , b.`brand_name`
          FROM tbl_luggagee_products AS a INNER JOIN brand_master AS b 
          ON a.search_brand = b.brand_master_id
          WHERE a.flag= 1  AND a.`lug_submenu_id` = ? AND b.flag = 1";
        $res['search_brand'] = $db->query($searchQry, [$lugIDD])->getResultArray();

        // Calculate Visible Page Links
        $maxVisibleLinks = 5; // Number of page links visible at a time
        $paginationLinks = [];

        $startPage = max(1, $page - floor($maxVisibleLinks / 2));
        $endPage = min($totalPages, $startPage + $maxVisibleLinks - 1);

        if ($startPage > 1) {
            $paginationLinks[] = [
                'label' => '<<',
                'page' => 1
            ];
        }

        if ($page > 1) {
            $paginationLinks[] = [
                'label' => 'Prev',
                'page' => $page - 1
            ];
        }

        for ($i = $startPage; $i <= $endPage; $i++) {
            $paginationLinks[] = [
                'label' => $i,
                'page' => $i,
                'active' => ($i == $page)
            ];
        }

        if ($page < $totalPages) {
            $paginationLinks[] = [
                'label' => 'Next',
                'page' => $page + 1
            ];
        }

        if ($endPage < $totalPages) {
            $paginationLinks[] = [
                'label' => '>>',
                'page' => $totalPages
            ];
        }

        $res['pagination'] = $paginationLinks;
        $res['total_products'] = $totalRows;

        $res['meta_title'] = "Touring Bike Accessories in Tamilnadu | Touring Bike Gear Tamilnadu";
        $res['meta_description'] = "Adventure Shoppe provides the best Motorcycle Touring Accessories in Coimbatore and Tamilnadu, featuring premium gear for safe and comfortable long rides.";
        return view('tourAccessories', $res);
    }


    public function tourDetails($segName, $prodID)
    {

        $prodIDD = base64_decode($prodID);
        $segment = strtolower(str_replace('-', ' ', $segName));

        $db = \Config\Database::connect();
        $res = $this->headerlist();

        // prod Details start
        $query1 = "SELECT * FROM tbl_luggagee_products WHERE flag = 1 AND prod_id = ?";
        $res['product'] = $db->query($query1, $prodIDD)->getResultArray();


        $tableName = "tbl_luggagee_products";
        $query2 = "SELECT * FROM `tbl_configuration` WHERE prod_id = ? AND tbl_name = ? AND flag =1";
        $res["config"] = $db->query($query2, [$prodIDD, $tableName])->getResultArray();


        $configDetails = [];
        if ($res["config"][0]["size"] == "" || $res["config"][0]["size"] == 'null') {
            $configDetails[] = [
                'size' => "",
                'stock' => ''
            ];
            $config['details'] = $configDetails;
            $res["tour_detail"] = array_merge($res['product'][0], $config['details'][0]);

        } else {
            $size = json_decode($res["config"][0]['size']);
            $stock = json_decode($res["config"][0]['soldout_status']);
            if ($size != "") {
                // Prepare arrays for display
                $filtrSize = $size;
                $sizeArray = [];

                $configDetails[] = [
                    'size' => $filtrSize,
                    'stock' => $stock,
                ];
                $config['details'] = $configDetails;
                $res["tour_detail"] = array_merge($res['product'][0], $config['details'][0]);
            }
            if ($config['details'][0] != "") {
                $res["tour_detail"] = array_merge($res['product'][0], $config['details'][0]);
            } else {
                $configDetails[] = [
                    'size' => "",
                    'stock' => "",
                ];

                $config['details'] = $configDetails;
                $res["tour_detail"] = $configDetails;
            }
        }

        // prod Details end 

        // to get similar products
        $product = $res['product'];

        $res['similarProducts'] = $this->getSimilartouring($product, 0.5, 5);

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

        // to get wishlist count 
        $res['wishlist_count'] = $this->getWishlistCount();

        $res['tbl_name'] = "tbl_luggagee_products";
        $res['current_url'] = current_url();

        $res['user_idd'] = $userID;



        // Recently viewed products START
        $recentQry = "SELECT * FROM `frequent_products` WHERE `flag` = 1 AND `user` = ? 
         GROUP BY `product_id` HAVING SUM(`prod_count`)<=10";

        $recentProducts = $db->query($recentQry, [$userID])->getResultArray();


        $recent = [];
        for ($i = 0; $i < count($recentProducts); $i++) {
            $tableName = $recentProducts[$i]['tbl_name'];
            $prodID = $recentProducts[$i]['product_id'];


            $query = "SELECT * FROM $tableName WHERE prod_id = ? AND flag = 1";
            $getProducts = $db->query($query, [$prodID])->getResultArray();

            $recent = array_merge($recent, $getProducts);
        }

        $res['recent_products'] = $recent;
        // Recently viewed products END 


        /* SIMILAR PRODUCTS NEW */
        $subMenu = $res["tour_detail"]['lug_submenu_id'];
        $PRODID = $res["tour_detail"]['prod_id'];

        $q1 = "SELECT DISTINCT * FROM `tbl_luggagee_products` WHERE `flag` = 1 AND `lug_submenu_id` = ?  AND `flag` = 1 AND prod_id <> ?";
        $res['similar'] = $db->query($q1, [$subMenu, $PRODID])->getResultArray();
        /* SIMILAR PRODUCTS NEW   END*/

        $res['meta_title'] = "Touring Bike Accessories in Tamilnadu | Touring Bike Gear Tamilnadu";
        $res['meta_description'] = "Adventure Shoppe provides the best Motorcycle Touring Accessories in Coimbatore and Tamilnadu, featuring premium gear for safe and comfortable long rides.";

        return view('tourDetails', $res);

    }

    private function getSimilartouring($product, $priceRange = 0.5, $limit = 5)
    {
        $db = \Config\Database::connect();
        $lug_menu_id = $product[0]['lug_menu_id'];
        $lug_submenu_id = $product[0]['lug_submenu_id'];
        $prod_id = $product[0]['prod_id'];

        $offer_price = $product[0]['offer_price'];

        // Calculate the price range
        $lowerBound = $offer_price - ($offer_price * $priceRange);
        $upperBound = $offer_price + ($offer_price * $priceRange);

        $query = "SELECT DISTINCT a.lug_menu AS modal, b.*
        FROM tbl_luggage_menu AS a 
        INNER JOIN tbl_luggagee_products AS b ON a.lug_menu_id = b.lug_menu_id
        WHERE (b.lug_menu_id = ? OR b.lug_submenu_id = ?) AND b.prod_id != ? AND b.flag = 1
        AND b.offer_price BETWEEN ? AND ? 
        ORDER BY RAND()
        LIMIT ?";

        return $db->query($query, [$lug_menu_id, $lug_submenu_id, $prod_id, $lowerBound, $upperBound, $limit])->getResultArray();
    }

    public function helmetAccessories($segName, $hsubID, $page_number)
    {

        $db = \Config\Database::connect();


        $hsubIDD = base64_decode($hsubID);
        $page = is_numeric($page_number) ? (int) $page_number : 1;

        $segment = strtolower(str_replace('-', ' ', $segName));

        $hsubIDD = base64_decode($hsubID);

        $res = $this->headerlist();

        $page = is_numeric($page_number) ? (int) $page_number : 1;


        $perPage = 12;
        // Count total number of products for pagination
        $totalRows = $db->query("SELECT COUNT(*) AS total FROM tbl_helmet_products WHERE h_submenu_id = ? AND flag = 1", [$hsubIDD])->getRow()->total;


        $totalPages = ceil($totalRows / $perPage);


        $currentPage = $page ? $page : ($this->request->getVar('page') ? $this->request->getVar('page') : 1);
        $offset = ($currentPage - 1) * $perPage;

        $res['h_access'] = $db->query(
            "SELECT a.h_submenu, b.* 
            FROM tbl_helmet_submenu AS a 
            INNER JOIN tbl_helmet_products AS b 
            ON a.h_submenu_id = b.h_submenu_id 
            WHERE a.h_submenu_id = ? AND b.flag = 1 
            ORDER BY b.product_name ASC 
            LIMIT $perPage OFFSET $offset",
            [$hsubIDD]
        )->getResultArray();



        $res['sub_id'] = $hsubIDD;

        $res['segment'] = $segName;


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


        // to get wishlist count 
        $res['wishlist_count'] = $this->getWishlistCount();

        // get Product Seacrh Filter data 

        $searchQry = "SELECT DISTINCT a.search_brand , b.`brand_name`
          FROM tbl_helmet_products AS a INNER JOIN brand_master AS b 
          ON a.search_brand = b.brand_master_id
          WHERE a.flag= 1 AND b.flag = 1 AND a.`h_submenu_id` = ?";
        $res['search_brand'] = $db->query($searchQry, [$hsubIDD])->getResultArray();

        // Calculate Visible Page Links
        $maxVisibleLinks = 5; // Number of page links visible at a time
        $paginationLinks = [];

        $startPage = max(1, $page - floor($maxVisibleLinks / 2));
        $endPage = min($totalPages, $startPage + $maxVisibleLinks - 1);

        if ($startPage > 1) {
            $paginationLinks[] = [
                'label' => '<<',
                'page' => 1
            ];
        }

        if ($page > 1) {
            $paginationLinks[] = [
                'label' => 'Prev',
                'page' => $page - 1
            ];
        }

        for ($i = $startPage; $i <= $endPage; $i++) {
            $paginationLinks[] = [
                'label' => $i,
                'page' => $i,
                'active' => ($i == $page)
            ];
        }

        if ($page < $totalPages) {
            $paginationLinks[] = [
                'label' => 'Next',
                'page' => $page + 1
            ];
        }

        if ($endPage < $totalPages) {
            $paginationLinks[] = [
                'label' => '>>',
                'page' => $totalPages
            ];
        }

        $res['pagination'] = $paginationLinks;
        $res['total_products'] = $totalRows;

        $res['meta_title'] = "Best Helmet Shop in Coimbatore | Racing Bike Helmets in Tamilnadu";
        $res['meta_description'] = "Adventure Shoppe offers Top Brand Helmet in Tamilnadu. Shop ISI-certified helmets in Coimbatore and across Tamilnadu for safety, style, and performance.";

        return view('hAccessories', $res);
    }


    public function helmetDetails($segName, $hID)
    {
        $segment = strtolower(str_replace('-', ' ', $segName));
        $hIDD = base64_decode($hID);

        $db = \Config\Database::connect();
        $res = $this->headerlist();


        // ProductDetails start
        $query1 = "SELECT * FROM tbl_helmet_products WHERE flag = 1 AND prod_id = ?";
        $res['product'] = $db->query($query1, $hIDD)->getResultArray();


        $tableName = "tbl_helmet_products";
        $query2 = "SELECT * FROM `tbl_configuration` WHERE prod_id = ? AND tbl_name = ? AND flag =1";
        $res["config"] = $db->query($query2, [$hIDD, $tableName])->getResultArray();


        $configDetails = [];
        if ($res["config"][0]["size"] == "" || $res["config"][0]["size"] == 'null') {
            $configDetails[] = [
                'size' => "",
                'stock' => ''
            ];
            $config['details'] = $configDetails;
            $res["h_details"] = array_merge($res['product'][0], $config['details'][0]);

        } else {
            $size = json_decode($res["config"][0]['size']);
            $stock = json_decode($res["config"][0]['soldout_status']);
            if ($size != "") {
                // Prepare arrays for display
                $filtrSize = $size;
                $sizeArray = [];

                $configDetails[] = [
                    'size' => $filtrSize,
                    'stock' => $stock,
                ];
                $config['details'] = $configDetails;
                $res["h_details"] = array_merge($res['product'][0], $config['details'][0]);
            }
            if ($config['details'][0] != "") {
                $res["h_details"] = array_merge($res['product'][0], $config['details'][0]);
            } else {
                $configDetails[] = [
                    'size' => "",
                    'stock' => "",
                ];

                $config['details'] = $configDetails;
                $res["h_details"] = $configDetails;
            }
        }



        // ProductDetails end
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

        $res['tbl_name'] = "tbl_helmet_products";

        // to get wishlist count 
        $res['wishlist_count'] = $this->getWishlistCount();


        // to get similar products
        $product = $res['product'];
        $res['similarProducts'] = $this->getSimilarhelmets($product, 0.5, 5);

        $res['current_url'] = current_url();
        $res['user_idd'] = $userID;


        // Recently viewed products START
        $recentQry = "SELECT * FROM `frequent_products` WHERE `flag` = 1 AND `user` = ? 
         GROUP BY `product_id` HAVING SUM(`prod_count`)<=10";

        $recentProducts = $db->query($recentQry, [$userID])->getResultArray();


        $recent = [];
        for ($i = 0; $i < count($recentProducts); $i++) {
            $tableName = $recentProducts[$i]['tbl_name'];
            $prodID = $recentProducts[$i]['product_id'];


            $query = "SELECT * FROM $tableName WHERE prod_id = ? AND flag = 1";
            $getProducts = $db->query($query, [$prodID])->getResultArray();

            $recent = array_merge($recent, $getProducts);
        }

        $res['recent_products'] = $recent;
        // Recently viewed products END 

        /* SIMILAR PRODUCTS NEW */
        $subMenu = $res["h_details"]['h_submenu_id'];
        $PRODID = $res["h_details"]['prod_id'];

        $q1 = "SELECT DISTINCT * FROM `tbl_helmet_products` WHERE `flag` = 1 AND `h_submenu_id` = ?  AND `flag` = 1 AND prod_id <> ?";
        $res['similar'] = $db->query($q1, [$subMenu, $PRODID])->getResultArray();

        /* SIMILAR PRODUCTS NEW   END*/

        $res['meta_title'] = "Helmets Accessories Shop in Coimbatore | Helmet Accessories in Tamilnadu";
        $res['meta_description'] = "Adventure Shoppe Your trusted Helmet Accessories Shop in Coimbatore, Tamilnadu. Find premium biking gear and accessories at the best prices!";

        return view('hDetails', $res);

    }
    private function getSimilarhelmets($product, $priceRange = 0.5, $limit = 5)
    {
        $db = \Config\Database::connect();

        $h_menu_id = $product[0]['h_menu_id'];
        $h_submenu_id = $product[0]['h_submenu_id'];
        $prod_id = $product[0]['prod_id'];

        $offer_price = $product[0]['offer_price'];

        // Calculate the price range
        $lowerBound = $offer_price - ($offer_price * $priceRange);
        $upperBound = $offer_price + ($offer_price * $priceRange);

        $query = "SELECT DISTINCT a.h_menu AS modal, b.*
        FROM tbl_helmet_menu AS a 
        INNER JOIN tbl_helmet_products AS b ON a.h_menu_id = b.h_menu_id
        WHERE (b.h_menu_id = ? OR b.h_submenu_id = ?) AND b.prod_id != ? AND b.flag = 1
        AND b.offer_price BETWEEN ? AND ? 
        ORDER BY RAND()
        LIMIT ?";


        return $db->query($query, [$h_menu_id, $h_submenu_id, $prod_id, $lowerBound, $upperBound, $limit])->getResultArray();
    }


    public function comboProducts()
    {
        $db = \Config\Database::connect();
        $res = $this->headerlist();

        $res['combo'] = $db->query(
            "SELECT * FROM tbl_combo_product 
            WHERE `flag` = 1"
        )->getResultArray();

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

        // to get wishlist count 
        $res['wishlist_count'] = $this->getWishlistCount();


        return view('comboProducts', $res);
    }

    public function comboDetails($segName)
    {

        $db = \Config\Database::connect();

        $segment = strtolower(str_replace('-', ' ', $segName));

        $res = $this->headerlist();


        $res['comboDetails'] = $db->query(
            "SELECT a.color_name , b.* 
                FROM tbl_color AS a  INNER JOIN tbl_combo_product AS b 
                ON  a.color_id = b.colour 
                WHERE b.redirect_url = '$segment'
                AND b.`flag` = 1
                "
        )->getResultArray();

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


        $res['tbl_name'] = "tbl_combo_product";

        // to get wishlist count 
        $res['wishlist_count'] = $this->getWishlistCount();

        return view('comboDetails', $res);
    }




    public function buyNow()
    {
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


        // to get wishlist count 
        $res['wishlist_count'] = $this->getWishlistCount();

        return view('buyNow', $res);
    }



    public function helmets(): string
    {
        return view('helmetlists');
    }

    public function details()
    {
        return view('details');
    }

    public function wishlist()
    {
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

        // to get wishlist count 
        $res['wishlist_count'] = $this->getWishlistCount();
        // Get wishList details
        $query = "SELECT `tbl_name`,`prod_id`,`size` ,`size_stock` FROM `tbl_wishlist` WHERE `flag`= 1 AND  user_id = ?";
        $wishListDetail = $db->query($query, [$userID])->getResultArray();



        $data = [];
        foreach ($wishListDetail as $item) {
            $tableName = $item['tbl_name'];
            $prodID = $item['prod_id'];
            $size = $item['size'];
            $size_stock = $item['size_stock'];
            $query = "SELECT a.prod_id,a.product_name, a.product_price, a.offer_price, a.product_img, a.stock_status,
       b.wishlist_id,b.tbl_name
       FROM $tableName AS a 
       
       INNER JOIN tbl_wishlist AS b 
       ON a.prod_id = b.prod_id
       WHERE b.flag = 1 AND a.prod_id = $prodID AND b.user_id = '$userID'";
            $result = $db->query($query)->getRow();
            $result->size = $size;
            $result->size_stock = $size_stock;
            $data[] = $result;

        }
        $res['wishListProd'] = $data;
        return view('wishlist', $res);
    }

    public function myorders()
    {
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

        // to get wishlist count 
        $res['wishlist_count'] = $this->getWishlistCount();


        // Get Order Summary
        $query = "SELECT * FROM `tbl_orders` WHERE `user_id` = ? AND `flag` = 1 AND  order_status <> 'initiated'";
        $orderDetails = $db->query($query, [$userID])->getResultArray();


        $orderSummaries = [];

        foreach ($orderDetails as $orders) {
            $orderID = $orders['order_id'];


            $query = "SELECT * FROM `tbl_order_item` WHERE `flag` = 1 AND `order_id` = ?";
            $itemDetails = $db->query($query, [$orderID])->getResultArray();


            $data = [];
            foreach ($itemDetails as $items) {

                $prodID = $items['prod_id'];
                $tableName = $items['table_name'];
                $color = $items['color'];
                $hexCode = $items['hex_code'];
                $size = $items['size'];



                $itemQuery =
                    "SELECT 
                    a.order_no,
                    a.sub_total,
                    a.courier_charge,
                    a.order_status,
                    a.updated_at AS delivered_time,
                    a.delivery_status,
                    a.order_date,
                    a.delivery_message,a.tracking_id,
                    b.quantity,
                    b.prod_price,
                    b.sub_total AS product_price,
                    b.color,
                    b.hex_code,
                    b.size,
                    b.config_image1,
                    b.color_name,
                    c.product_name,
                    c.product_img,
                    c.stock_status,
                    d.*,
                    e.state_title,
                    f.dist_name
                FROM tbl_orders AS a
                LEFT JOIN tbl_order_item AS b ON a.order_id = b.order_id
                INNER JOIN $tableName AS c ON b.prod_id = c.prod_id
                INNER JOIN tbl_user_address AS d ON a.add_id = d.add_id
                INNER JOIN tbl_state AS e ON e.state_id = d.state_id
                INNER JOIN tbl_district AS f ON f.dist_id = d.dist_id
                WHERE 
                    d.default_addr = 1 
                    AND d.flag = 1 
                    AND a.user_id = ? 
                    AND b.order_id = ? 
                    AND c.prod_id = ? 
                    AND c.flag = 1 
                    AND a.flag = 1 
                    AND b.color = ? 
                    AND b.hex_code = ? 
                    AND b.size = ?
                  ORDER BY a.order_date DESC";
                $itemRes = $db->query($itemQuery, [$userID, $orderID, $prodID, $color, $hexCode, $size])->getRowArray();



                if ($itemRes) {
                    $data[] = $itemRes;
                }
            }

            $orderSummaries[$orderID] = $data;
            krsort($orderSummaries);


        }
        $res['summary'] = $orderSummaries;

        $res['username'] = $db->query("SELECT `username`, email FROM `tbl_users` WHERE `user_id` = $userID ")->getResultArray();

        return view('myorders', $res);
    }
    public function successpage(): string
    {

        return view('successpage');
    }

    public function failurepage(): string
    {

        return view('failurepage');
    }

    public function brands_viewall()
    {

        $db = \Config\Database::connect();
        $res = $this->headerlist();

        // to get wishlist count 
        $res['wishlist_count'] = $this->getWishlistCount();

        // toget cart count
        $userID = session()->get('user_id');
        $query = "SELECT * FROM tbl_user_cart WHERE user_id = ? AND flag =1";
        $usercount = $db->query($query, [$userID])->getResultArray();
        if ($usercount > 0) {
            $res['cart_count'] = sizeof($usercount);

        } else {
            $res['cart_count'] = 0;
        }

        $res['meta_title'] = "Top Brand Bike Accessories in Coimbatore | Top Bike Gear Tamilnadu";
        $res['meta_description'] = "Adventure Shoppe offers top branded bike accessories in Coimbatore and Tamilnadu, featuring premium gear, parts, and riding essentials for all bike enthusiasts.";
        return view('brands_viewall', $res);
    }

    public function Brands($segName, $segID)
    {
        $db = \Config\Database::connect();

        $BrandID = base64_decode($segID);



        $res = $this->headerlist();


        // to get wishlist count 
        $res['wishlist_count'] = $this->getWishlistCount();

        // toget cart count
        $userID = session()->get('user_id');
        $query = "SELECT * FROM tbl_user_cart WHERE user_id = ? AND flag =1";
        $usercount = $db->query($query, [$userID])->getResultArray();
        if ($usercount > 0) {
            $res['cart_count'] = sizeof($usercount);

        } else {
            $res['cart_count'] = 0;
        }


        $query = "SELECT prod_id, access_id AS brand_id, sub_access_id AS modal_id, product_name, 
           billing_name, product_price, offer_price AS prod_price,  offer_type AS offer, offer_details, 
           arrival_status, stock_status, redirect_url, product_img, img_1, img_2, 
           img_3, img_4, img_5, img_6, img_7, img_8, img_9, img_10, prod_desc,  hot_sale, tbl_name, 
           search_brand, weight, weight_units, quantity, specifications, flag
    FROM tbl_accessories_list
    WHERE flag = 1 AND `search_brand` = $BrandID
    UNION ALL
    SELECT prod_id, r_menu_id AS brand_id, r_sub_id AS modal_id, product_name, 
           billing_name, product_price, offer_price AS prod_price, offer_type AS offer, offer_details, 
           arrival_status, stock_status, redirect_url, product_img, img_1, img_2, img_3, 
           img_4, img_5, img_6, img_7, img_8, img_9, img_10, prod_desc,  hot_sale, tbl_name, search_brand, weight, 
           weight_units, quantity, specifications, flag
    FROM tbl_rproduct_list
    WHERE flag = 1 AND `search_brand` = $BrandID
    UNION ALL
    SELECT prod_id, h_menu_id AS brand_id, h_submenu_id AS modal_id, product_name, 
           billing_name, product_price, offer_price AS prod_price, offer_type AS offer, offer_details, arrival_status, 
           stock_status, redirect_url, product_img, img_1, img_2, img_3, img_4, img_5, img_6, 
           img_7, img_8, img_9, img_10, prod_desc, hot_sale, tbl_name, search_brand, weight, weight_units, 
           quantity, specifications, flag
    FROM tbl_helmet_products
    WHERE flag = 1 AND `search_brand` = $BrandID
    UNION ALL
    SELECT prod_id, lug_menu_id AS brand_id, lug_submenu_id AS modal_id, product_name, 
           billing_name, product_price, offer_price AS prod_price, offer_type AS offer, offer_details, arrival_status, 
           stock_status, redirect_url, product_img, img_1, img_2, img_3, img_4, img_5, img_6, 
           img_7, img_8, img_9, img_10, prod_desc, hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
           specifications, flag
    FROM tbl_luggagee_products
    WHERE flag = 1 AND `search_brand` = $BrandID
    UNION ALL
    SELECT prod_id, camp_menu_id AS brand_id, c_submenu_id AS modal_id, product_name, 
           billing_name, product_price, offer_price AS prod_price, offer_type AS offer, offer_details, arrival_status, 
           stock_status, redirect_url, product_img, img_1, img_2, img_3, img_4, img_5, img_6, 
           img_7, img_8, img_9, img_10, prod_desc, hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
           specifications, flag
    FROM tbl_camping_products
    WHERE flag = 1 AND `search_brand` = $BrandID
   
    ";

        $res['product'] = $db->query($query)->getResultArray();





        $res['meta_title'] = "Top Brand Bike Accessories in Coimbatore | Top Bike Gear Tamilnadu";
        $res['meta_description'] = "Adventure Shoppe offers top branded bike accessories in Coimbatore and Tamilnadu, featuring premium gear, parts, and riding essentials for all bike enthusiasts.";


        return view('brands', $res);

    }



    public function ordersummary()
    {
        $db = \Config\Database::connect();

        // Fetch data from multiple tables
        $res = $this->headerlist();

        // Get wishlist count
        $res['wishlist_count'] = $this->getWishlistCount();

        // Get cart count
        $userID = session()->get('user_id');
        $query = "SELECT * FROM tbl_user_cart WHERE user_id = ? AND flag = 1";
        $usercount = $db->query($query, [$userID])->getResultArray();
        $res['cart_count'] = count($usercount);

        return view('ordersummary', $res);
    }



    public function helmetView()
    {

        $db = \Config\Database::connect();
        $res = $this->headerlist();

        // to get wishlist count 
        $res['wishlist_count'] = $this->getWishlistCount();

        // toget cart count
        $userID = session()->get('user_id');
        $query = "SELECT * FROM tbl_user_cart WHERE user_id = ? AND flag =1";
        $usercount = $db->query($query, [$userID])->getResultArray();
        if ($usercount > 0) {
            $res['cart_count'] = sizeof($usercount);

        } else {
            $res['cart_count'] = 0;
        }


        $res['h_submenu_list'] = $db->query('SELECT * FROM `tbl_helmet_submenu` WHERE `flag` = 1 AND `h_menu_id` = 2')->getResultArray();

        $res['meta_title'] = "Best Helmet Shop in Coimbatore | Racing Bike Helmets in Tamilnadu";
        $res['meta_description'] = "Adventure Shoppe offers Top Brand Helmet in Tamilnadu. Shop ISI-certified helmets in Coimbatore and across Tamilnadu for safety, style, and performance.";

        return view('helmetView', $res);
    }

    public function searchfiltrView()
    {
        $db = \Config\Database::connect();
        $res = $this->headerlist();

        // to get wishlist count 
        $res['wishlist_count'] = $this->getWishlistCount();

        // toget cart count
        $userID = session()->get('user_id');
        $query = "SELECT * FROM tbl_user_cart WHERE user_id = ? AND flag =1";
        $usercount = $db->query($query, [$userID])->getResultArray();
        if ($usercount > 0) {
            $res['cart_count'] = sizeof($usercount);

        } else {
            $res['cart_count'] = 0;
        }

        return view('searchfiltrView', $res);
    }
    public function terms()
    {
        $db = \Config\Database::connect();
        $res = $this->headerlist();

        // to get wishlist count 
        $res['wishlist_count'] = $this->getWishlistCount();

        // toget cart count
        $userID = session()->get('user_id');
        $query = "SELECT * FROM tbl_user_cart WHERE user_id = ? AND flag =1";
        $usercount = $db->query($query, [$userID])->getResultArray();
        if ($usercount > 0) {
            $res['cart_count'] = sizeof($usercount);

        } else {
            $res['cart_count'] = 0;
        }

        return view('terms', $res);
    }
    public function policies()
    {
        $db = \Config\Database::connect();
        $res = $this->headerlist();

        // to get wishlist count 
        $res['wishlist_count'] = $this->getWishlistCount();

        // toget cart count
        $userID = session()->get('user_id');
        $query = "SELECT * FROM tbl_user_cart WHERE user_id = ? AND flag =1";
        $usercount = $db->query($query, [$userID])->getResultArray();
        if ($usercount > 0) {
            $res['cart_count'] = sizeof($usercount);

        } else {
            $res['cart_count'] = 0;
        }

        return view('policies', $res);
    }

    public function newArrivalViewall($page_number)
    {
        $db = \Config\Database::connect();

        $res = $this->headerlist();

        $page = is_numeric($page_number) ? (int) $page_number : 1;


        // Pagination Settings
        $perPage = 64;
        // to get wishlist count 
        $res['wishlist_count'] = $this->getWishlistCount();

        // toget cart count
        $userID = session()->get('user_id');
        $query = "SELECT * FROM tbl_user_cart WHERE user_id = ? AND flag =1";
        $usercount = $db->query($query, [$userID])->getResultArray();
        if ($usercount > 0) {
            $res['cart_count'] = sizeof($usercount);

        } else {
            $res['cart_count'] = 0;
        }


        // Count total number of products for pagination
        $totalData = $db->query("
        SELECT COUNT(*) AS total_count
        FROM (
            SELECT prod_id
            FROM tbl_accessories_list
            WHERE flag = 1 AND `offer_type` = 0 AND `arrival_status` =  1 
            UNION ALL
            SELECT prod_id
            FROM tbl_rproduct_list
            WHERE flag = 1 AND `offer_type` = 0 AND `arrival_status` =  1 
            UNION ALL
            SELECT prod_id
            FROM tbl_helmet_products
            WHERE flag = 1 AND `offer_type` = 0 AND `arrival_status` =  1 
            UNION ALL
            SELECT prod_id
            FROM tbl_luggagee_products
            WHERE flag = 1 AND `offer_type` = 0 AND `arrival_status` =  1 
            UNION ALL
            SELECT prod_id
            FROM tbl_camping_products
            WHERE flag = 1 AND `offer_type` = 0 AND `arrival_status` =  1 
        ) AS combined_table
    ")->getRow();



        $totalRows = $totalData->total_count;

        $totalPages = ceil($totalRows / $perPage);
        $currentPage = $page ? $page : ($this->request->getVar('page') ? $this->request->getVar('page') : 1);
        $offset = ($currentPage - 1) * $perPage;




        // get new arrivals
        $res['new_arrivals'] = $db->query("SELECT prod_id, access_id AS brand_id, sub_access_id AS modal_id, product_name, 
            billing_name, product_price, offer_price, offer_type, offer_details, 
            arrival_status, stock_status, redirect_url, product_img, img_1, img_2, 
            img_3, img_4, img_5, img_6, img_7, img_8, img_9, img_10, prod_desc, hot_sale, tbl_name, 
            search_brand, weight, weight_units, quantity, specifications, flag, 2 AS order_col
        FROM tbl_accessories_list
        WHERE flag = 1 AND arrival_status =  1
        UNION ALL
        SELECT prod_id, r_menu_id AS brand_id, r_sub_id AS modal_id, product_name, 
            billing_name, product_price, offer_price, offer_type, offer_details, 
            arrival_status, stock_status, redirect_url, product_img, img_1, img_2, img_3, 
            img_4, img_5, img_6, img_7, img_8, img_9, img_10, prod_desc, hot_sale, tbl_name, search_brand, weight, 
            weight_units, quantity, specifications, flag, 3 AS order_col
        FROM tbl_rproduct_list
        WHERE flag = 1 AND arrival_status =  1
        UNION ALL
        SELECT prod_id, h_menu_id AS brand_id, h_submenu_id AS modal_id, product_name, 
            billing_name, product_price, offer_price, offer_type, offer_details, arrival_status, 
            stock_status, redirect_url, product_img, img_1, img_2, img_3, img_4, img_5, img_6, 
            img_7, img_8, img_9, img_10, prod_desc, hot_sale, tbl_name, search_brand, weight, weight_units, 
            quantity, specifications, flag, 4 AS order_col
        FROM tbl_helmet_products
        WHERE flag = 1 AND arrival_status =  1
        UNION ALL
        SELECT prod_id, lug_menu_id AS brand_id, lug_submenu_id AS modal_id, product_name, 
            billing_name, product_price, offer_price, offer_type, offer_details, arrival_status, 
            stock_status, redirect_url, product_img, img_1, img_2, img_3, img_4, img_5, img_6, 
            img_7, img_8, img_9, img_10, prod_desc,  hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
            specifications, flag, 5 AS order_col
        FROM tbl_luggagee_products
        WHERE flag = 1 AND arrival_status =  1
        UNION ALL
        SELECT prod_id, camp_menu_id AS brand_id, c_submenu_id AS modal_id, product_name, 
            billing_name, product_price, offer_price, offer_type, offer_details, arrival_status, 
            stock_status, redirect_url, product_img, img_1, img_2, img_3, img_4, img_5, img_6, 
            img_7, img_8, img_9, img_10, prod_desc,hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
            specifications, flag, 6 AS order_col
        FROM tbl_camping_products
        WHERE flag = 1 AND arrival_status =  1
        ORDER BY order_col, prod_id
         LIMIT ? OFFSET ?
    ", [$perPage, $offset])->getResultArray();



        // get Product Seacrh Filter data 
        $res['search_brand'] = $db->query("SELECT DISTINCT a.search_brand, a.`tbl_name` ,  b.`brand_name`
                FROM tbl_products AS a INNER JOIN brand_master AS b 
                ON a.search_brand = b.brand_master_id
                WHERE a.flag= 1 AND b.flag = 1 AND a.arrival_status = 1
        UNION 
        SELECT DISTINCT a.search_brand, a.`tbl_name` ,  b.`brand_name`
                FROM tbl_accessories_list AS a INNER JOIN brand_master AS b 
                ON a.search_brand = b.brand_master_id
                WHERE a.flag= 1 AND b.flag = 1 AND a.arrival_status = 1
        UNION 
        SELECT DISTINCT a.search_brand, a.`tbl_name` ,  b.`brand_name`
                FROM tbl_rproduct_list AS a INNER JOIN brand_master AS b 
                ON a.search_brand = b.brand_master_id
                WHERE a.flag= 1 AND b.flag = 1
        UNION 
        SELECT DISTINCT a.search_brand, a.`tbl_name` ,  b.`brand_name`
                FROM tbl_helmet_products AS a INNER JOIN brand_master AS b 
                ON a.search_brand = b.brand_master_id
                WHERE a.flag= 1 AND b.flag = 1 AND a.arrival_status = 1
        UNION

        SELECT DISTINCT a.search_brand, a.`tbl_name` ,  b.`brand_name`
                FROM tbl_camping_products AS a INNER JOIN brand_master AS b 
                ON a.search_brand = b.brand_master_id
                WHERE a.flag= 1 AND b.flag = 1 AND a.arrival_status = 1
        UNION 
        SELECT DISTINCT a.search_brand, a.`tbl_name` ,  b.`brand_name`
                FROM tbl_luggagee_products AS a INNER JOIN brand_master AS b 
                ON a.search_brand = b.brand_master_id
                WHERE a.flag= 1 AND b.flag = 1 AND a.arrival_status = 1
        ")->getResultArray();


        $res['search_brand'] = $this->getDistinctValues($res['search_brand'], 'search_brand');

        // Calculate Visible Page Links
        $maxVisibleLinks = 5; // Number of page links visible at a time
        $paginationLinks = [];

        $startPage = max(1, $page - floor($maxVisibleLinks / 2));
        $endPage = min($totalPages, $startPage + $maxVisibleLinks - 1);

        if ($startPage > 1) {
            $paginationLinks[] = [
                'label' => '<<',
                'page' => 1
            ];
        }

        if ($page > 1) {
            $paginationLinks[] = [
                'label' => 'Prev',
                'page' => $page - 1
            ];
        }

        for ($i = $startPage; $i <= $endPage; $i++) {
            $paginationLinks[] = [
                'label' => $i,
                'page' => $i,
                'active' => ($i == $page)
            ];
        }

        if ($page < $totalPages) {
            $paginationLinks[] = [
                'label' => 'Next',
                'page' => $page + 1
            ];
        }

        if ($endPage < $totalPages) {
            $paginationLinks[] = [
                'label' => '>>',
                'page' => $totalPages
            ];
        }

        $res['pagination'] = $paginationLinks;
        $res['total_products'] = $totalRows;


        return view('newArrivalViewall', $res);

    }

    private function getDistinctValues($array, $key)
    {
        $tempArray = [];
        $keyArray = [];

        foreach ($array as $val) {
            if (!in_array($val[$key], $keyArray)) {
                $keyArray[] = $val[$key];
                $tempArray[] = $val;
            }
        }
        return $tempArray;
    }


    public function offers($page_number)
    {
        $db = \Config\Database::connect();
        $res = $this->headerlist();

        $page = is_numeric($page_number) ? (int) $page_number : 1;

        // Pagination Settings
        $perPage = 44;

        // to get wishlist count 
        $res['wishlist_count'] = $this->getWishlistCount();

        // toget cart count
        $userID = session()->get('user_id');
        $query = "SELECT * FROM tbl_user_cart WHERE user_id = ? AND flag =1";
        $usercount = $db->query($query, [$userID])->getResultArray();
        if ($usercount > 0) {
            $res['cart_count'] = sizeof($usercount);

        } else {
            $res['cart_count'] = 0;
        }

        // Count total number of products for pagination
        $totalData = $db->query("
        SELECT COUNT(*) AS total_count
        FROM (
            SELECT prod_id
            FROM tbl_accessories_list
            WHERE flag = 1 AND `offer_type` = 0 AND `offer_details` <> 0
            UNION ALL
            SELECT prod_id
            FROM tbl_rproduct_list
            WHERE flag = 1 AND `offer_type` = 0 AND `offer_details` <> 0
            UNION ALL
            SELECT prod_id
            FROM tbl_helmet_products
            WHERE flag = 1 AND `offer_type` = 0 AND `offer_details` <> 0
            UNION ALL
            SELECT prod_id
            FROM tbl_luggagee_products
            WHERE flag = 1 AND `offer_type` = 0 AND `offer_details` <> 0
            UNION ALL
            SELECT prod_id
            FROM tbl_camping_products
            WHERE flag = 1 AND `offer_type` = 0 AND `offer_details` <> 0
        ) AS combined_table
    ")->getRow();

        $totalRows = $totalData->total_count;

        $totalPages = ceil($totalRows / $perPage);
        $currentPage = $page ? $page : ($this->request->getVar('page') ? $this->request->getVar('page') : 1);
        $offset = ($currentPage - 1) * $perPage;


        // get offers
        $res['offers'] = $db->query("SELECT prod_id, access_id AS brand_id, sub_access_id AS modal_id, product_name, 
           billing_name, product_price, offer_price, offer_type, offer_details,
           arrival_status, stock_status, redirect_url, product_img, img_1, img_2, 
           img_3, img_4, img_5, img_6, img_7, img_8, img_9, img_10, prod_desc, hot_sale, tbl_name, 
           search_brand, weight, weight_units, quantity, specifications, flag, 2 AS order_col
    FROM tbl_accessories_list
    WHERE flag = 1 AND `offer_type` =  0 AND `offer_details` <> 0
    UNION ALL
    SELECT prod_id, r_menu_id AS brand_id, r_sub_id AS modal_id, product_name, 
           billing_name, product_price, offer_price, offer_type, offer_details, 
           arrival_status, stock_status, redirect_url, product_img, img_1, img_2, img_3, 
           img_4, img_5, img_6, img_7, img_8, img_9, img_10, prod_desc, hot_sale, tbl_name, search_brand, weight, 
           weight_units, quantity, specifications, flag, 3 AS order_col
    FROM tbl_rproduct_list
    WHERE flag = 1 AND `offer_type` =  0 AND `offer_details` <> 0
    UNION ALL
    SELECT prod_id, h_menu_id AS brand_id, h_submenu_id AS modal_id, product_name, 
           billing_name, product_price, offer_price, offer_type, offer_details, arrival_status, 
           stock_status, redirect_url, product_img, img_1, img_2, img_3, img_4, img_5, img_6, 
           img_7, img_8, img_9, img_10, prod_desc,hot_sale, tbl_name, search_brand, weight, weight_units, 
           quantity, specifications, flag, 4 AS order_col
    FROM tbl_helmet_products
    WHERE flag = 1 AND `offer_type` =  0 AND `offer_details` <> 0
    UNION ALL
    SELECT prod_id, lug_menu_id AS brand_id, lug_submenu_id AS modal_id, product_name, 
           billing_name, product_price, offer_price, offer_type, offer_details, arrival_status, 
           stock_status, redirect_url, product_img, img_1, img_2, img_3, img_4, img_5, img_6, 
           img_7, img_8, img_9, img_10, prod_desc,hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
           specifications, flag, 5 AS order_col
    FROM tbl_luggagee_products
    WHERE flag = 1 AND `offer_type` =  0 AND `offer_details` <> 0
    UNION ALL
    SELECT prod_id, camp_menu_id AS brand_id, c_submenu_id AS modal_id, product_name, 
           billing_name, product_price, offer_price, offer_type, offer_details, arrival_status, 
           stock_status, redirect_url, product_img, img_1, img_2, img_3, img_4, img_5, img_6, 
           img_7, img_8, img_9, img_10, prod_desc, hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
           specifications, flag, 6 AS order_col
    FROM tbl_camping_products
    WHERE flag = 1 AND `offer_type` =  0 AND `offer_details` <> 0
    ORDER BY order_col, prod_id

    LIMIT ? OFFSET ?
    ", [$perPage, $offset])->getResultArray();



        // search brand 
        $res['search_brand'] = $db->query("SELECT DISTINCT a.search_brand , a.tbl_name , b.`brand_name`
FROM tbl_accessories_list AS a INNER JOIN brand_master AS b 
ON a.search_brand = b.brand_master_id
WHERE a.flag= 1 AND b.flag = 1 AND a.`offer_type` =  0
UNION ALL
SELECT DISTINCT a.search_brand ,a.tbl_name, b.`brand_name`
FROM tbl_rproduct_list AS a INNER JOIN brand_master AS b 
ON a.search_brand = b.brand_master_id
WHERE a.flag= 1 AND b.flag = 1 AND a.`offer_type` =  0
UNION 
SELECT DISTINCT a.search_brand ,a.tbl_name, b.`brand_name`
FROM tbl_helmet_products AS a INNER JOIN brand_master AS b 
ON a.search_brand = b.brand_master_id
WHERE a.flag= 1 AND b.flag = 1 AND a.`offer_type` =  0
UNION
SELECT DISTINCT a.search_brand ,a.tbl_name, b.`brand_name`
FROM tbl_luggagee_products AS a INNER JOIN brand_master AS b 
ON a.search_brand = b.brand_master_id
WHERE a.flag= 1 AND b.flag = 1 AND a.`offer_type` =  0
UNION 
SELECT DISTINCT a.search_brand ,a.tbl_name, b.`brand_name`
FROM tbl_camping_products AS a INNER JOIN brand_master AS b 
ON a.search_brand = b.brand_master_id
WHERE a.flag= 1 AND b.flag = 1 AND a.`offer_type` =  0


")->getResultArray();

        $res['search_brand'] = $this->getDistinctValues($res['search_brand'], 'search_brand');

        // Calculate Visible Page Links
        $maxVisibleLinks = 5; // Number of page links visible at a time
        $paginationLinks = [];

        $startPage = max(1, $page - floor($maxVisibleLinks / 2));
        $endPage = min($totalPages, $startPage + $maxVisibleLinks - 1);

        if ($startPage > 1) {
            $paginationLinks[] = [
                'label' => '<<',
                'page' => 1
            ];
        }

        if ($page > 1) {
            $paginationLinks[] = [
                'label' => 'Prev',
                'page' => $page - 1
            ];
        }

        for ($i = $startPage; $i <= $endPage; $i++) {
            $paginationLinks[] = [
                'label' => $i,
                'page' => $i,
                'active' => ($i == $page)
            ];
        }

        if ($page < $totalPages) {
            $paginationLinks[] = [
                'label' => 'Next',
                'page' => $page + 1
            ];
        }

        if ($endPage < $totalPages) {
            $paginationLinks[] = [
                'label' => '>>',
                'page' => $totalPages
            ];
        }

        $res['pagination'] = $paginationLinks;
        $res['total_products'] = $totalRows;


        return view('offers', $res);
    }

    // Loadmore for OfferDetails 
    public function loadmoreOffer()
    {

        $db = \Config\Database::connect();
        $page = $this->request->getPost('page');

        // Pagination Settings
        $perPage = 44;

        // to get wishlist count 
        $res['wishlist_count'] = $this->getWishlistCount();

        // toget cart count
        $userID = session()->get('user_id');
        $query = "SELECT * FROM tbl_user_cart WHERE user_id = ? AND flag =1";
        $usercount = $db->query($query, [$userID])->getResultArray();
        if ($usercount > 0) {
            $res['cart_count'] = sizeof($usercount);

        } else {
            $res['cart_count'] = 0;
        }

        // Count total number of products for pagination
        $totalData = $db->query("
        SELECT COUNT(*) AS total_count
        FROM (
            SELECT prod_id
            FROM tbl_accessories_list
            WHERE flag = 1 AND `offer_type` = 0 AND `offer_details` <> 0
            UNION ALL
            SELECT prod_id
            FROM tbl_rproduct_list
            WHERE flag = 1 AND `offer_type` = 0 AND `offer_details` <> 0
            UNION ALL
            SELECT prod_id
            FROM tbl_helmet_products
            WHERE flag = 1 AND `offer_type` = 0 AND `offer_details` <> 0
            UNION ALL
            SELECT prod_id
            FROM tbl_luggagee_products
            WHERE flag = 1 AND `offer_type` = 0 AND `offer_details` <> 0
            UNION ALL
            SELECT prod_id
            FROM tbl_camping_products
            WHERE flag = 1 AND `offer_type` = 0 AND `offer_details` <> 0
        ) AS combined_table
    ")->getRow();

        $totalRows = $totalData->total_count;

        $totalPages = ceil($totalRows / $perPage);
        $currentPage = $this->request->getVar('page') ?? 1;
        $offset = ($currentPage - 1) * $perPage;

        // get offers
        $res['offers'] = $db->query("SELECT prod_id, access_id AS brand_id, sub_access_id AS modal_id, product_name, 
     billing_name, product_price, offer_price, offer_type, offer_details,
     arrival_status, stock_status, redirect_url, product_img, img_1, img_2, 
     img_3, img_4, img_5, img_6, img_7, img_8, img_9, img_10, prod_desc, hot_sale, tbl_name, 
     search_brand, weight, weight_units, quantity, specifications, flag, 2 AS order_col
FROM tbl_accessories_list
WHERE flag = 1 AND `offer_type` =  0 AND `offer_details` <> 0
UNION ALL
SELECT prod_id, r_menu_id AS brand_id, r_sub_id AS modal_id, product_name, 
     billing_name, product_price, offer_price, offer_type, offer_details, 
     arrival_status, stock_status, redirect_url, product_img, img_1, img_2, img_3, 
     img_4, img_5, img_6, img_7, img_8, img_9, img_10, prod_desc, hot_sale, tbl_name, search_brand, weight, 
     weight_units, quantity, specifications, flag, 3 AS order_col
FROM tbl_rproduct_list
WHERE flag = 1 AND `offer_type` =  0 AND `offer_details` <> 0
UNION ALL
SELECT prod_id, h_menu_id AS brand_id, h_submenu_id AS modal_id, product_name, 
     billing_name, product_price, offer_price, offer_type, offer_details, arrival_status, 
     stock_status, redirect_url, product_img, img_1, img_2, img_3, img_4, img_5, img_6, 
     img_7, img_8, img_9, img_10, prod_desc,hot_sale, tbl_name, search_brand, weight, weight_units, 
     quantity, specifications, flag, 4 AS order_col
FROM tbl_helmet_products
WHERE flag = 1 AND `offer_type` =  0 AND `offer_details` <> 0
UNION ALL
SELECT prod_id, lug_menu_id AS brand_id, lug_submenu_id AS modal_id, product_name, 
     billing_name, product_price, offer_price, offer_type, offer_details, arrival_status, 
     stock_status, redirect_url, product_img, img_1, img_2, img_3, img_4, img_5, img_6, 
     img_7, img_8, img_9, img_10, prod_desc,hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
     specifications, flag, 5 AS order_col
FROM tbl_luggagee_products
WHERE flag = 1 AND `offer_type` =  0 AND `offer_details` <> 0
UNION ALL
SELECT prod_id, camp_menu_id AS brand_id, c_submenu_id AS modal_id, product_name, 
     billing_name, product_price, offer_price, offer_type, offer_details, arrival_status, 
     stock_status, redirect_url, product_img, img_1, img_2, img_3, img_4, img_5, img_6, 
     img_7, img_8, img_9, img_10, prod_desc, hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
     specifications, flag, 6 AS order_col
FROM tbl_camping_products
WHERE flag = 1 AND `offer_type` =  0 AND `offer_details` <> 0
ORDER BY  RAND() order_col, prod_id

LIMIT ? OFFSET ?
", [$perPage, $offset])->getResultArray();

        // Calculate Visible Page Links
        $maxVisibleLinks = 5; // Number of page links visible at a time
        $paginationLinks = [];

        $startPage = max(1, $page - floor($maxVisibleLinks / 2));
        $endPage = min($totalPages, $startPage + $maxVisibleLinks - 1);

        if ($startPage > 1) {
            $paginationLinks[] = [
                'label' => '<<',
                'page' => 1
            ];
        }

        if ($page > 1) {
            $paginationLinks[] = [
                'label' => 'Prev',
                'page' => $page - 1
            ];
        }

        for ($i = $startPage; $i <= $endPage; $i++) {
            $paginationLinks[] = [
                'label' => $i,
                'page' => $i,
                'active' => ($i == $page)
            ];
        }

        if ($page < $totalPages) {
            $paginationLinks[] = [
                'label' => 'Next',
                'page' => $page + 1
            ];
        }

        if ($endPage < $totalPages) {
            $paginationLinks[] = [
                'label' => '>>',
                'page' => $totalPages
            ];
        }
        $res = ([
            'products' => $res['offers'],
            'pagination' => $paginationLinks
        ]);
        echo json_encode($res);

    }


    // Loadmore for OfferDetails 
    public function loadmoreHotsale()
    {

        $db = \Config\Database::connect();
        $page = $this->request->getPost('page');

        // Pagination Settings
        $perPage = 12;

        // to get wishlist count 
        $res['wishlist_count'] = $this->getWishlistCount();

        // toget cart count
        $userID = session()->get('user_id');
        $query = "SELECT * FROM tbl_user_cart WHERE user_id = ? AND flag =1";
        $usercount = $db->query($query, [$userID])->getResultArray();
        if ($usercount > 0) {
            $res['cart_count'] = sizeof($usercount);

        } else {
            $res['cart_count'] = 0;
        }

        $totalData = $db->query("
        SELECT COUNT(*) AS total_count
        FROM (
            SELECT prod_id
            FROM tbl_accessories_list
            WHERE flag = 1 AND `offer_type` = 0 AND `hot_sale` = 1
            UNION ALL
            SELECT prod_id
            FROM tbl_rproduct_list
            WHERE flag = 1 AND `offer_type` = 0 AND `hot_sale` = 1
            UNION ALL
            SELECT prod_id
            FROM tbl_helmet_products
            WHERE flag = 1 AND `offer_type` = 0 AND `hot_sale` = 1
            UNION ALL
            SELECT prod_id
            FROM tbl_luggagee_products
            WHERE flag = 1 AND `offer_type` = 0 AND `hot_sale` = 1
            UNION ALL
            SELECT prod_id
            FROM tbl_camping_products
            WHERE flag = 1 AND `offer_type` = 0 AND `hot_sale` = 1
        ) AS combined_table
    ")->getRow();

        $totalRows = $totalData->total_count;

        $totalPages = ceil($totalRows / $perPage);
        $currentPage = $this->request->getVar('page') ?? 1;
        $offset = ($currentPage - 1) * $perPage;



        $res['hotsale'] = $db->query('SELECT prod_id, brand_id, modal_id, product_name, billing_name, product_price, 
        offer_price, offer_type, offer_details, arrival_status, stock_status, 
        redirect_url, product_img, img_1, img_2, img_3, img_4, img_5, img_6, 
        img_7, img_8, img_9, img_10, prod_desc, 
        hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
        specifications, flag, 1 AS order_col
 FROM tbl_products
 WHERE flag = 1 AND hot_sale = 1
 UNION ALL
 SELECT prod_id, access_id AS brand_id, sub_access_id AS modal_id, product_name, 
        billing_name, product_price, offer_price, offer_type, offer_details, 
        arrival_status, stock_status, redirect_url, product_img, img_1, img_2, 
        img_3, img_4, img_5, img_6, img_7, img_8, img_9, img_10, prod_desc,  hot_sale, tbl_name, 
        search_brand, weight, weight_units, quantity, specifications, flag, 2 AS order_col
 FROM tbl_accessories_list
 WHERE flag = 1 AND hot_sale = 1
 UNION ALL
 SELECT prod_id, r_menu_id AS brand_id, r_sub_id AS modal_id, product_name, 
        billing_name, product_price, offer_price, offer_type, offer_details, 
        arrival_status, stock_status, redirect_url, product_img, img_1, img_2, img_3, 
        img_4, img_5, img_6, img_7, img_8, img_9, img_10, prod_desc,  hot_sale, tbl_name, search_brand, weight, 
        weight_units, quantity, specifications, flag, 3 AS order_col
 FROM tbl_rproduct_list
 WHERE flag = 1 AND hot_sale = 1
 UNION ALL
 SELECT prod_id, h_menu_id AS brand_id, h_submenu_id AS modal_id, product_name, 
        billing_name, product_price, offer_price, offer_type, offer_details, arrival_status, 
        stock_status, redirect_url, product_img, img_1, img_2, img_3, img_4, img_5, img_6, 
        img_7, img_8, img_9, img_10, prod_desc, hot_sale, tbl_name, search_brand, weight, weight_units, 
        quantity, specifications, flag, 4 AS order_col
 FROM tbl_helmet_products
 WHERE flag = 1 AND hot_sale = 1
 UNION ALL
 SELECT prod_id, lug_menu_id AS brand_id, lug_submenu_id AS modal_id, product_name, 
        billing_name, product_price, offer_price, offer_type, offer_details, arrival_status, 
        stock_status, redirect_url, product_img, img_1, img_2, img_3, img_4, img_5, img_6, 
        img_7, img_8, img_9, img_10, prod_desc, hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
        specifications, flag, 5 AS order_col
 FROM tbl_luggagee_products
 WHERE flag = 1 AND hot_sale = 1
 UNION ALL
 SELECT prod_id, camp_menu_id AS brand_id, c_submenu_id AS modal_id, product_name, 
        billing_name, product_price, offer_price, offer_type, offer_details, arrival_status, 
        stock_status, redirect_url, product_img, img_1, img_2, img_3, img_4, img_5, img_6, 
        img_7, img_8, img_9, img_10, prod_desc, hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
        specifications, flag, 6 AS order_col
 FROM tbl_camping_products
 WHERE flag = 1 AND hot_sale = 1
 ORDER BY order_col, prod_id
LIMIT ? OFFSET ?', [$perPage, $offset])->getResultArray();

        // Calculate Visible Page Links
        $maxVisibleLinks = 5; // Number of page links visible at a time
        $paginationLinks = [];

        $startPage = max(1, $page - floor($maxVisibleLinks / 2));
        $endPage = min($totalPages, $startPage + $maxVisibleLinks - 1);

        if ($startPage > 1) {
            $paginationLinks[] = [
                'label' => '<<',
                'page' => 1
            ];
        }

        if ($page > 1) {
            $paginationLinks[] = [
                'label' => 'Prev',
                'page' => $page - 1
            ];
        }

        for ($i = $startPage; $i <= $endPage; $i++) {
            $paginationLinks[] = [
                'label' => $i,
                'page' => $i,
                'active' => ($i == $page)
            ];
        }

        if ($page < $totalPages) {
            $paginationLinks[] = [
                'label' => 'Next',
                'page' => $page + 1
            ];
        }

        if ($endPage < $totalPages) {
            $paginationLinks[] = [
                'label' => '>>',
                'page' => $totalPages
            ];
        }

        $res = ([
            'products' => $res['hotsale'],
            'pagination' => $paginationLinks
        ]);
        echo json_encode($res);

    }

    public function loadmoreNewarrivals()
    {

        $db = \Config\Database::connect();

        $page = $this->request->getPost('page');

        // Pagination Settings
        $perPage = 64;

        // Count total number of products for pagination
        $totalData = $db->query("
        SELECT COUNT(*) AS total_count
        FROM (
            SELECT prod_id
            FROM tbl_accessories_list
            WHERE flag = 1 AND `offer_type` = 0 AND `arrival_status` =  1
            UNION ALL
            SELECT prod_id
            FROM tbl_rproduct_list
            WHERE flag = 1 AND `offer_type` = 0 AND `arrival_status` =  1
            UNION ALL
            SELECT prod_id
            FROM tbl_helmet_products
            WHERE flag = 1 AND `offer_type` = 0 AND `arrival_status` =  1
            UNION ALL
            SELECT prod_id
            FROM tbl_luggagee_products
            WHERE flag = 1 AND `offer_type` = 0 AND `arrival_status` =  1
            UNION ALL
            SELECT prod_id
            FROM tbl_camping_products
            WHERE flag = 1 AND `offer_type` = 0 AND `arrival_status` =  1
        ) AS combined_table
    ")->getRow();

        $totalRows = $totalData->total_count;

        $totalPages = ceil($totalRows / $perPage);
        $currentPage = $this->request->getVar('page') ?? 1;
        $offset = ($currentPage - 1) * $perPage;


        $res['new_arrival'] = $db->query("SELECT prod_id, access_id AS brand_id, sub_access_id AS modal_id, product_name, 
            billing_name, product_price, offer_price, offer_type, offer_details, 
            arrival_status, stock_status, redirect_url, product_img, img_1, img_2, 
            img_3, img_4, img_5, img_6, img_7, img_8, img_9, img_10, prod_desc, hot_sale, tbl_name, 
            search_brand, weight, weight_units, quantity, specifications, flag, 2 AS order_col
        FROM tbl_accessories_list
        WHERE flag = 1 AND arrival_status =  1
        UNION ALL
        SELECT prod_id, r_menu_id AS brand_id, r_sub_id AS modal_id, product_name, 
            billing_name, product_price, offer_price, offer_type, offer_details, 
            arrival_status, stock_status, redirect_url, product_img, img_1, img_2, img_3, 
            img_4, img_5, img_6, img_7, img_8, img_9, img_10, prod_desc, hot_sale, tbl_name, search_brand, weight, 
            weight_units, quantity, specifications, flag, 3 AS order_col
        FROM tbl_rproduct_list
        WHERE flag = 1 AND arrival_status =  1
        UNION ALL
        SELECT prod_id, h_menu_id AS brand_id, h_submenu_id AS modal_id, product_name, 
            billing_name, product_price, offer_price, offer_type, offer_details, arrival_status, 
            stock_status, redirect_url, product_img, img_1, img_2, img_3, img_4, img_5, img_6, 
            img_7, img_8, img_9, img_10, prod_desc, hot_sale, tbl_name, search_brand, weight, weight_units, 
            quantity, specifications, flag, 4 AS order_col
        FROM tbl_helmet_products
        WHERE flag = 1 AND arrival_status =  1
        UNION ALL
        SELECT prod_id, lug_menu_id AS brand_id, lug_submenu_id AS modal_id, product_name, 
            billing_name, product_price, offer_price, offer_type, offer_details, arrival_status, 
            stock_status, redirect_url, product_img, img_1, img_2, img_3, img_4, img_5, img_6, 
            img_7, img_8, img_9, img_10, prod_desc,  hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
            specifications, flag, 5 AS order_col
        FROM tbl_luggagee_products
        WHERE flag = 1 AND arrival_status =  1
        UNION ALL
        SELECT prod_id, camp_menu_id AS brand_id, c_submenu_id AS modal_id, product_name, 
            billing_name, product_price, offer_price, offer_type, offer_details, arrival_status, 
            stock_status, redirect_url, product_img, img_1, img_2, img_3, img_4, img_5, img_6, 
            img_7, img_8, img_9, img_10, prod_desc,hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
            specifications, flag, 6 AS order_col
        FROM tbl_camping_products
        WHERE flag = 1 AND arrival_status =  1
        ORDER BY order_col, prod_id
        
LIMIT ? OFFSET ?
", [$perPage, $offset])->getResultArray();

        // Calculate Visible Page Links
        $maxVisibleLinks = 5; // Number of page links visible at a time
        $paginationLinks = [];

        $startPage = max(1, $page - floor($maxVisibleLinks / 2));
        $endPage = min($totalPages, $startPage + $maxVisibleLinks - 1);

        if ($startPage > 1) {
            $paginationLinks[] = [
                'label' => '<<',
                'page' => 1
            ];
        }

        if ($page > 1) {
            $paginationLinks[] = [
                'label' => 'Prev',
                'page' => $page - 1
            ];
        }

        for ($i = $startPage; $i <= $endPage; $i++) {
            $paginationLinks[] = [
                'label' => $i,
                'page' => $i,
                'active' => ($i == $page)
            ];
        }

        if ($page < $totalPages) {
            $paginationLinks[] = [
                'label' => 'Next',
                'page' => $page + 1
            ];
        }

        if ($endPage < $totalPages) {
            $paginationLinks[] = [
                'label' => '>>',
                'page' => $totalPages
            ];
        }

        $res = ([
            'products' => $res['new_arrival'],
            'pagination' => $paginationLinks
        ]);
        echo json_encode($res);

    }

    public function camping($segName, $segID)
    {

        $segment = ucwords(str_replace('-', ' ', $segName));

        $menuID = base64_decode($segID);

        $db = \Config\Database::connect();
        $res = $this->headerlist();

        $res['camping_list'] = $db->query(
            "SELECT a.*,b.camp_menu FROM `tbl_camping_submenu` AS a 
            INNER JOIN tbl_camping_menu AS b ON  a.camp_menuid = b.camp_menu_id 
            WHERE a.flag = 1 AND b.camp_menu_id = $menuID;"
        )->getResultArray();



        // to get cart count 
        $userID = session()->get('user_id');
        $query = "SELECT * FROM tbl_user_cart WHERE user_id = ?  AND flag =1";
        $usercount = $db->query($query, [$userID])->getResultArray();
        if ($usercount > 0) {
            $res['cart_count'] = sizeof($usercount);

        } else {
            $res['cart_count'] = 0;
        }
        // end cart count


        // to get wishlist count 
        $res['wishlist_count'] = $this->getWishlistCount();

        return view('camping', $res);
    }

    public function campingProducts($segname, $segmentID, $page_number)
    {


        $db = \Config\Database::connect();
        $res = $this->headerlist();


        $page = is_numeric($page_number) ? (int) $page_number : 1;
        $segment = strtolower(str_replace('-', ' ', $segname));

        $subID = base64_decode($segmentID);



        $subName = ucwords(str_replace('-', ' ', $segname));

        // Pagination Settings
        $perPage = 12;
        // Count total number of products for pagination
        $totalRows = $db->query("SELECT COUNT(*) AS total FROM tbl_camping_products WHERE c_submenu_id = ? AND flag = 1", [$subID])->getRow()->total;

        $totalPages = ceil($totalRows / $perPage);
        $currentPage = $page ? $page : ($this->request->getVar('page') ? $this->request->getVar('page') : 1);
        $offset = ($currentPage - 1) * $perPage;
        $res['product'] = $db->query(
            "SELECT a.c_submenu, b.* 
             FROM tbl_camping_submenu AS a 
             INNER JOIN tbl_camping_products AS b 
             ON a.c_submenu_id = b.c_submenu_id 
             WHERE b.flag = 1 AND a.c_submenu_id = ? 
             ORDER BY b.product_name ASC 
             LIMIT ? OFFSET ?",
            [$subID, $perPage, $offset]
        )->getResultArray();


        $res['segment'] = $segname;


        // to get cart count S
        $userID = session()->get('user_id');
        $query = "SELECT * FROM tbl_user_cart WHERE user_id = ?  AND flag =1";
        $usercount = $db->query($query, [$userID])->getResultArray();
        if ($usercount > 0) {
            $res['cart_count'] = sizeof($usercount);

        } else {
            $res['cart_count'] = 0;
        }

        // to get wishlist count 
        $res['wishlist_count'] = $this->getWishlistCount();

        // get Product Seacrh Filter data 
        $searchQry = "SELECT DISTINCT a.search_brand , b.`brand_name`
          FROM tbl_camping_products AS a INNER JOIN brand_master AS b 
          ON a.search_brand = b.brand_master_id
          WHERE a.flag= 1 AND b.flag = 1 AND a.c_submenu_id = ?";

        $res['search_brand'] = $db->query($searchQry, [$subID])->getResultArray();

        $res['sub_id'] = $subID;


        // Calculate Visible Page Links
        $maxVisibleLinks = 5; // Number of page links visible at a time
        $paginationLinks = [];

        $startPage = max(1, $page - floor($maxVisibleLinks / 2));
        $endPage = min($totalPages, $startPage + $maxVisibleLinks - 1);

        if ($startPage > 1) {
            $paginationLinks[] = [
                'label' => '<<',
                'page' => 1
            ];
        }

        if ($page > 1) {
            $paginationLinks[] = [
                'label' => 'Prev',
                'page' => $page - 1
            ];
        }

        for ($i = $startPage; $i <= $endPage; $i++) {
            $paginationLinks[] = [
                'label' => $i,
                'page' => $i,
                'active' => ($i == $page)
            ];
        }

        if ($page < $totalPages) {
            $paginationLinks[] = [
                'label' => 'Next',
                'page' => $page + 1
            ];
        }

        if ($endPage < $totalPages) {
            $paginationLinks[] = [
                'label' => '>>',
                'page' => $totalPages
            ];
        }

        $res['pagination'] = $paginationLinks;
        $res['total_products'] = $totalRows;

        $res['meta_title'] = "Top Camping Gear Dealers in Coimbatore | Camping Gear Store Tamilnadu";
        $res['meta_description'] = "Adventure Shoppe is the Top Camping Equipment shop in Coimbatore, Tamilnadu. Find quality tents, gear & outdoor tools for your next adventure!";


        return view('campProducts', $res);
    }
    public function campingProductsDetails($segName, $prodID)
    {

        $pID = base64_decode($prodID);

        $db = \Config\Database::connect();
        $res = $this->headerlist();


        $query1 = "SELECT * FROM tbl_camping_products WHERE flag = 1 AND prod_id = ?";
        $res['product'] = $db->query($query1, $pID)->getResultArray();


        $tableName = "tbl_camping_products";
        $query2 = "SELECT * FROM `tbl_configuration` WHERE prod_id = ? AND tbl_name = ? AND flag =1";
        $res["config"] = $db->query($query2, [$pID, $tableName])->getResultArray();

        $configDetails = [];
        if ($res["config"][0]["size"] == "" || $res["config"][0]["size"] == 'null') {
            $configDetails[] = [
                'size' => "",
                'stock' => ''
            ];
            $config['details'] = $configDetails;
            $res["prod_details"] = array_merge($res['product'][0], $config['details'][0]);

        } else {
            $size = json_decode($res["config"][0]['size']);
            $stock = json_decode($res["config"][0]['soldout_status']);
            if ($size != "") {
                // Prepare arrays for display
                $filtrSize = $size;
                $sizeArray = [];

                $configDetails[] = [
                    'size' => $filtrSize,
                    'stock' => $stock,
                ];
                $config['details'] = $configDetails;
                $res["prod_details"] = array_merge($res['product'][0], $config['details'][0]);
            }
            if ($config['details'][0] != "") {
                $res["prod_details"] = array_merge($res['product'][0], $config['details'][0]);
            } else {
                echo "5";
                $configDetails[] = [
                    'size' => "",
                    'stock' => "",
                ];

                $config['details'] = $configDetails;
                $res["prod_details"] = $configDetails;
            }
        }

        // to get similar products
        $product = $res['product'];
        $res['similarProducts'] = $this->getSimilarCampProducts($product, 0.5, 5);

        $res['tbl_name'] = "tbl_camping_products";
        // to get cart count 
        $userID = session()->get('user_id');
        $query = "SELECT * FROM tbl_user_cart WHERE user_id = ?  AND flag =1";
        $usercount = $db->query($query, [$userID])->getResultArray();
        if ($usercount > 0) {
            $res['cart_count'] = sizeof($usercount);

        } else {
            $res['cart_count'] = 0;
        }

        $res['current_url'] = current_url();
        // to get wishlist count 
        $res['wishlist_count'] = $this->getWishlistCount();

        $res['user_idd'] = $userID;


        // Recently viewed products START
        $recentQry = "SELECT * FROM `frequent_products` WHERE `flag` = 1 AND `user` = ? 
         GROUP BY `product_id` HAVING SUM(`prod_count`)<=10";

        $recentProducts = $db->query($recentQry, [$userID])->getResultArray();


        $recent = [];
        for ($i = 0; $i < count($recentProducts); $i++) {
            $tableName = $recentProducts[$i]['tbl_name'];
            $prodID = $recentProducts[$i]['product_id'];


            $query = "SELECT * FROM $tableName WHERE prod_id = ? AND flag = 1";
            $getProducts = $db->query($query, [$prodID])->getResultArray();

            $recent = array_merge($recent, $getProducts);
        }

        $res['recent_products'] = $recent;
        // Recently viewed products END 

        /* SIMILAR PRODUCTS NEW */
        $subMenu = $res["prod_details"]['c_submenu_id'];
        $PRODID = $res["prod_details"]['prod_id'];

        $q1 = "SELECT DISTINCT * FROM `tbl_camping_products` WHERE `flag` = 1 AND `c_submenu_id` = ?  AND `flag` = 1 AND prod_id <> ?";
        $res['similar'] = $db->query($q1, [$subMenu, $PRODID])->getResultArray();

        $res['meta_title'] = "Top Camping Gear Dealers in Coimbatore | Camping Gear Store Tamilnadu";
        $res['meta_description'] = "Adventure Shoppe is the Top Camping Equipment shop in Coimbatore, Tamilnadu. Find quality tents, gear & outdoor tools for your next adventure!";


        /* SIMILAR PRODUCTS NEW   END*/
        return view('campDetails', $res);

    }
    private function getSimilarCampProducts($product, $priceRange = 0.5, $limit = 5)
    {
        $db = \Config\Database::connect();
        $camp_menu_id = $product[0]['camp_menu_id'];
        $c_submenu_id = $product[0]['c_submenu_id'];
        $prod_id = $product[0]['prod_id'];

        $offer_price = $product[0]['offer_price'];

        // Calculate the price range
        $lowerBound = $offer_price - ($offer_price * $priceRange);
        $upperBound = $offer_price + ($offer_price * $priceRange);

        $query = "SELECT DISTINCT a.camp_menu AS modal, b.*
        FROM tbl_camping_menu AS a 
        INNER JOIN tbl_camping_products AS b ON a.camp_menu_id = b.camp_menu_id
        WHERE (b.camp_menu_id = ? OR b.c_submenu_id = ?) AND b.prod_id != ? AND b.flag = 1
        AND b.offer_price BETWEEN ? AND ? 
        ORDER BY RAND()
        LIMIT ?";

        return $db->query($query, [$camp_menu_id, $c_submenu_id, $prod_id, $lowerBound, $upperBound, $limit])->getResultArray();
    }

    public function hotsale($page_number)
    {
        $db = \Config\Database::connect();
        $res = $this->headerlist();
        $page = is_numeric($page_number) ? (int) $page_number : 1;

        // Pagination Settings
        $perPage = 12;


        // to get cart count 
        $userID = session()->get('user_id');
        $query = "SELECT * FROM tbl_user_cart WHERE user_id = ?  AND flag =1";
        $usercount = $db->query($query, [$userID])->getResultArray();
        if ($usercount > 0) {
            $res['cart_count'] = sizeof($usercount);

        } else {
            $res['cart_count'] = 0;
        }


        // Count total number of products for pagination
        $totalData = $db->query("
         SELECT COUNT(*) AS total_count
         FROM (
             SELECT prod_id
             FROM tbl_accessories_list
             WHERE ( `hot_sale` = 1 OR offer_type = 0) AND flag = 1
             UNION ALL
             SELECT prod_id
             FROM tbl_rproduct_list
             WHERE ( `hot_sale` = 1 OR offer_type = 0) AND flag = 1
             UNION ALL
             SELECT prod_id
             FROM tbl_helmet_products
             WHERE ( `hot_sale` = 1 OR offer_type = 0) AND flag = 1
             UNION ALL
             SELECT prod_id
             FROM tbl_luggagee_products
             WHERE ( `hot_sale` = 1 OR offer_type = 0) AND flag = 1
             UNION ALL
             SELECT prod_id
             FROM tbl_camping_products
             WHERE ( `hot_sale` = 1 OR offer_type = 0) AND flag = 1
         ) AS combined_table
     ")->getRow();


        $totalRows = $totalData->total_count;



        $totalPages = ceil($totalRows / $perPage);
        $currentPage = $page ? $page : ($this->request->getVar('page') ? $this->request->getVar('page') : 1);
        $offset = ($currentPage - 1) * $perPage;


        // to get wishlist count 
        $res['wishlist_count'] = $this->getWishlistCount();
        // get HOT SALE
        $res['hotsale'] = $db->query('SELECT prod_id, brand_id, modal_id, product_name, billing_name, product_price, 
        offer_price, offer_type, offer_details, arrival_status, stock_status, 
        redirect_url, product_img, img_1, img_2, img_3, img_4, img_5, img_6, 
        img_7, img_8, img_9, img_10, prod_desc, 
        hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
        specifications, flag, 1 AS order_col
 FROM tbl_products
 WHERE  (hot_sale = 1 OR offer_type = 0) AND flag = 1 
 UNION ALL
 SELECT prod_id, access_id AS brand_id, sub_access_id AS modal_id, product_name, 
        billing_name, product_price, offer_price, offer_type, offer_details, 
        arrival_status, stock_status, redirect_url, product_img, img_1, img_2, 
        img_3, img_4, img_5, img_6, img_7, img_8, img_9, img_10, prod_desc,  hot_sale, tbl_name, 
        search_brand, weight, weight_units, quantity, specifications, flag, 2 AS order_col
 FROM tbl_accessories_list
 WHERE  (hot_sale = 1 OR offer_type = 0) AND flag = 1 
 UNION ALL
 SELECT prod_id, r_menu_id AS brand_id, r_sub_id AS modal_id, product_name, 
        billing_name, product_price, offer_price, offer_type, offer_details, 
        arrival_status, stock_status, redirect_url, product_img, img_1, img_2, img_3, 
        img_4, img_5, img_6, img_7, img_8, img_9, img_10, prod_desc,  hot_sale, tbl_name, search_brand, weight, 
        weight_units, quantity, specifications, flag, 3 AS order_col
 FROM tbl_rproduct_list
 WHERE  (hot_sale = 1 OR offer_type = 0) AND flag = 1 
 UNION ALL
 SELECT prod_id, h_menu_id AS brand_id, h_submenu_id AS modal_id, product_name, 
        billing_name, product_price, offer_price, offer_type, offer_details, arrival_status, 
        stock_status, redirect_url, product_img, img_1, img_2, img_3, img_4, img_5, img_6, 
        img_7, img_8, img_9, img_10, prod_desc, hot_sale, tbl_name, search_brand, weight, weight_units, 
        quantity, specifications, flag, 4 AS order_col
 FROM tbl_helmet_products
 WHERE  (hot_sale = 1 OR offer_type = 0) AND flag = 1 
 UNION ALL
 SELECT prod_id, lug_menu_id AS brand_id, lug_submenu_id AS modal_id, product_name, 
        billing_name, product_price, offer_price, offer_type, offer_details, arrival_status, 
        stock_status, redirect_url, product_img, img_1, img_2, img_3, img_4, img_5, img_6, 
        img_7, img_8, img_9, img_10, prod_desc, hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
        specifications, flag, 5 AS order_col
 FROM tbl_luggagee_products
 WHERE  (hot_sale = 1 OR offer_type = 0) AND flag = 1 
 UNION ALL
 SELECT prod_id, camp_menu_id AS brand_id, c_submenu_id AS modal_id, product_name, 
        billing_name, product_price, offer_price, offer_type, offer_details, arrival_status, 
        stock_status, redirect_url, product_img, img_1, img_2, img_3, img_4, img_5, img_6, 
        img_7, img_8, img_9, img_10, prod_desc, hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
        specifications, flag, 6 AS order_col
 FROM tbl_camping_products
 WHERE  (hot_sale = 1 OR offer_type = 0) AND flag = 1 
 ORDER BY order_col, prod_id
LIMIT ? OFFSET ?', [$perPage, $offset])->getResultArray();


        // search brand 
        $res['search_brand'] = $db->query("SELECT DISTINCT a.search_brand,a.tbl_name , b.`brand_name`
 FROM tbl_products AS a INNER JOIN brand_master AS b 
 ON a.search_brand = b.brand_master_id
 WHERE (a.hot_sale = 1 OR a.offer_type = 0) AND a.flag = 1  AND b.flag = 1 
 UNION ALL
 SELECT DISTINCT a.search_brand , a.tbl_name , b.`brand_name`
 FROM tbl_accessories_list AS a INNER JOIN brand_master AS b 
 ON a.search_brand = b.brand_master_id
 WHERE (a.hot_sale = 1 OR a.offer_type = 0) AND a.flag = 1  AND b.flag = 1 
 UNION ALL
 SELECT DISTINCT a.search_brand ,a.tbl_name, b.`brand_name`
 FROM tbl_rproduct_list AS a INNER JOIN brand_master AS b 
 ON a.search_brand = b.brand_master_id
 WHERE (a.hot_sale = 1 OR a.offer_type = 0) AND a.flag = 1  AND b.flag = 1 
 UNION 
 SELECT DISTINCT a.search_brand ,a.tbl_name, b.`brand_name`
 FROM tbl_helmet_products AS a INNER JOIN brand_master AS b 
 ON a.search_brand = b.brand_master_id
 WHERE (a.hot_sale = 1 OR a.offer_type = 0) AND a.flag = 1  AND b.flag = 1 
 UNION
 SELECT DISTINCT a.search_brand ,a.tbl_name, b.`brand_name`
 FROM tbl_luggagee_products AS a INNER JOIN brand_master AS b 
 ON a.search_brand = b.brand_master_id
 WHERE (a.hot_sale = 1 OR a.offer_type = 0) AND a.flag = 1  AND b.flag = 1 
 UNION 
 SELECT DISTINCT a.search_brand ,a.tbl_name, b.`brand_name`
 FROM tbl_camping_products AS a INNER JOIN brand_master AS b 
 ON a.search_brand = b.brand_master_id
 WHERE (a.hot_sale = 1 OR a.offer_type = 0) AND a.flag = 1  AND b.flag = 1 
 ")->getResultArray();
        $res['search_brand'] = $this->getDistinctValues($res['search_brand'], 'search_brand');


        // Calculate Visible Page Links
        $maxVisibleLinks = 5; // Number of page links visible at a time
        $paginationLinks = [];

        $startPage = max(1, $page - floor($maxVisibleLinks / 2));
        $endPage = min($totalPages, $startPage + $maxVisibleLinks - 1);

        if ($startPage > 1) {
            $paginationLinks[] = [
                'label' => '<<',
                'page' => 1
            ];
        }

        if ($page > 1) {
            $paginationLinks[] = [
                'label' => 'Prev',
                'page' => $page - 1
            ];
        }

        for ($i = $startPage; $i <= $endPage; $i++) {
            $paginationLinks[] = [
                'label' => $i,
                'page' => $i,
                'active' => ($i == $page)
            ];
        }

        if ($page < $totalPages) {
            $paginationLinks[] = [
                'label' => 'Next',
                'page' => $page + 1
            ];
        }

        if ($endPage < $totalPages) {
            $paginationLinks[] = [
                'label' => '>>',
                'page' => $totalPages
            ];
        }

        $res['pagination'] = $paginationLinks;
        $res['total_products'] = $totalRows;

        return view("hotsale", $res);

    }



    public function contactUs()
    {
        $db = \Config\Database::connect();
        $res = $this->headerlist();
        // to get wishlist count
        $res['wishlist_count'] = $this->getWishlistCount();
        // toget cart count
        $userID = session()->get('user_id');
        $query = "SELECT * FROM tbl_user_cart WHERE user_id = ? AND flag =1";
        $usercount = $db->query($query, [$userID])->getResultArray();
        if ($usercount > 0) {
            $res['cart_count'] = sizeof($usercount);
        } else {
            $res['cart_count'] = 0;
        }
        return view('contactUs', $res);
    }



    public function transaction()
    {
        $db = \Config\Database::connect();
        $res = $this->headerlist();
        // to get wishlist count
        $res['wishlist_count'] = $this->getWishlistCount();
        // toget cart count
        $userID = session()->get('user_id');
        $query = "SELECT * FROM tbl_user_cart WHERE user_id = ? AND flag =1";
        $usercount = $db->query($query, [$userID])->getResultArray();
        if ($usercount > 0) {
            $res['cart_count'] = sizeof($usercount);
        } else {
            $res['cart_count'] = 0;
        }
        return view('transaction', $res);
    }


    public function inserTransaction()
    {
        $db = \Config\Database::connect();
        $model = new TransactionModel;
        $userID = session()->get('user_id');
        $transID = $this->request->getPost('transaction');

        $data = [
            'user_id' => $userID,
            'transaction' => $transID
        ];
        $insert = $model->insert($data);
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

    public function trackingOrder($segment1)
    {

        $orderID = base64_decode($segment1);
        $db = \Config\Database::connect();
        $userID = session()->get('user_id');

        $res = $this->headerlist();
        // to get cart count 
        $userID = session()->get('user_id');
        $query = "SELECT * FROM tbl_user_cart WHERE user_id = ?  AND flag =1";
        $usercount = $db->query($query, [$userID])->getResultArray();
        if ($usercount > 0) {
            $res['cart_count'] = sizeof($usercount);

        } else {
            $res['cart_count'] = 0;
        }

        // to get wishlist count 
        $res['wishlist_count'] = $this->getWishlistCount();

        $query = "SELECT * FROM `tbl_order_item` WHERE `flag` = 1 AND `order_id` = ?";
        $itemDetails = $db->query($query, [$orderID])->getResultArray();


        $data = [];
        foreach ($itemDetails as $items) {

            $prodID = $items['prod_id'];
            $tableName = $items['table_name'];
            $color = $items['color'];
            $hexCode = $items['hex_code'];
            $size = $items['size'];


            $itemQuery = "SELECT 
                a.order_id,
                a.order_no,
                a.sub_total,
                a.courier_charge,
                a.order_status,
                a.courier_partner,
              
                a.delivery_status,
                DATE_FORMAT(a.log, '%a, %d %b') AS ordered_date,
                DATE_FORMAT(a.process_date, '%a, %d %b') AS process_date,
                DATE_FORMAT(a.shipped_date, '%a, %d %b') AS shipped_date,
                DATE_FORMAT(a.delivery_date, '%a, %d %b') AS delivery_date,

                DATE_FORMAT(a.log, '%h:%i %p') AS ordered_time,
                DATE_FORMAT(a.process_date, '%h:%i %p') AS process_time,
                DATE_FORMAT(a.shipped_date, '%h:%i %p') AS shipped_time,
                DATE_FORMAT(a.delivery_date, '%h:%i %p') AS delivery_time,
                a.delivery_message,
                a.tracking_id,
                 DATE_FORMAT(a.updated_at, '%d-%m-%Y') AS updatedDate,
                b.quantity,
                b.prod_price,
                b.sub_total AS product_price,
                b.color,
                b.hex_code,
                b.size,
                b.config_image1,
                b.color_name,
                c.product_name,
                c.product_img,
                c.stock_status,
                d.*,
                e.state_title,
                f.dist_name
            FROM tbl_orders AS a
            LEFT JOIN tbl_order_item AS b ON a.order_id = b.order_id
            INNER JOIN $tableName AS c ON b.prod_id = c.prod_id
            INNER JOIN tbl_user_address AS d ON a.add_id = d.add_id
            INNER JOIN tbl_state AS e ON e.state_id = d.state_id
            INNER JOIN tbl_district AS f ON f.dist_id = d.dist_id
            WHERE 
                d.default_addr = 1 
                AND d.flag = 1 
                AND a.user_id = ? 
                AND b.order_id = ? 
                AND c.prod_id = ? 
                AND c.flag = 1 
                AND a.flag = 1 
                AND b.color = ? 
                AND b.hex_code = ? 
                AND b.size = ?
              ORDER BY a.order_date DESC";


            $itemRes = $db->query($itemQuery, [$userID, $orderID, $prodID, $color, $hexCode, $size])->getRowArray();



            if ($itemRes) {
                $data[] = $itemRes;
            }
        }


        $res['order_detail'] = $data;



        return view("trackingorder", $res);
    }

    public function insertFrequentDetails()
    {
        $db = \Config\Database::connect();
        $data = $this->request->getPost();


        $prodID = $this->request->getPost('prod_id');
        $tblName = $this->request->getPost('tbl_name');
        $user = $this->request->getPost('user');


        $count = 1;
        $modal = new FrequentModel();

        $query = "SELECT * FROM `frequent_products` WHERE `flag` = 1 AND `product_id` = ? AND `tbl_name` = ? AND user = ?";
        $getOldData = $db->query($query, [$prodID, $tblName, $user])->getResultArray();


        if (count($getOldData) > 0) {
            $prevCount = $getOldData[0]['prod_count'];
            $prodid = $getOldData[0]['product_id'];


            $tbl_name = $getOldData[0]['tbl_name'];
            $newCount = $prevCount + 1;

            $query1 = "UPDATE frequent_products SET prod_count = ? WHERE `product_id` = ? AND `tbl_name` = ? AND user = ?";
            $updateProduct = $db->query($query1, [$newCount, $prodid, $tbl_name, $user]);

            $affectedRows = $db->affectedRows();

            if ($affectedRows) {
                $result['code'] = 200;
                $result['message'] = 'Frequent Viewed product updated';
            } else {
                $result['code'] = 400;
                $result['message'] = 'No rows affected in update.';
            }
        } else if (count($getOldData) == 0) {
            $data = [
                'product_id' => $prodID,
                'tbl_name' => $tblName,
                'prod_count' => $count,
                'user' => $user
            ];

            $res = $modal->insert($data);

            if ($res) {
                $result['code'] = 200;
                $result['message'] = 'Frequent Viewed product inserted';
            } else {
                $result['code'] = 400;
                $result['message'] = 'Insert failed.';
            }
        } else {
            $result['code'] = 400;
            $result['message'] = 'Frequent Products Update Failed';
        }


        echo json_encode($result);
    }


    public function cancelOrders()
    {
        $db = \Config\Database::connect();

        $data = $this->request->getPost();
        $OrderID = $this->request->getPost('orderid');
        $message = $this->request->getPost('cancel_reason');
        $cancelStatus = 1;
        $deliveryStatus = 6;
        $deliververyMessage = 6;


        $query = "UPDATE tbl_orders SET cancel_status = ?, cancel_reason = ? ,delivery_status = ?,delivery_message =?  WHERE order_id = ?";
        $updateOrder = $db->query($query, [$cancelStatus, $message, $deliveryStatus, $deliververyMessage, $OrderID]);


        $affectedRow = $db->affectedRows();
        if ($affectedRow == 1) {
            $result['code'] = 200;
            $result['message'] = 'Your order has been cancelled successfully';
        } else {
            $result['code'] = 400;
            $result['message'] = 'Your order has not been canceled.';
        }

        echo json_encode($result);

    }



}
