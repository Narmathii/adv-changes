<?php

namespace App\Controllers;

class SearchController extends BaseController
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
    public function searchData()
    {

        $db = \Config\Database::connect();
        $searchData = $this->request->getGet('search_bar');

        $res['search_value'] = $searchData;


        $query1 = "SELECT 
        prod_id, brand_id, modal_id, product_name, billing_name, product_price, 
        offer_price, offer_type, offer_details, arrival_status, stock_status, 
        redirect_url, product_img,  img_1, img_2, img_3, img_4, img_5, img_6, 
           img_7, img_8, img_9, img_10, prod_desc, 
           hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
           specifications, flag, 1 AS order_col
    FROM 
         tbl_products
         WHERE  `product_name` LIKE ? AND `flag` = 1 
    UNION ALL
    SELECT 
        prod_id, access_id AS brand_id, sub_access_id AS modal_id, product_name, billing_name, product_price, 
        offer_price, offer_type, offer_details, arrival_status, stock_status, 
        redirect_url, product_img,  img_1, img_2, img_3, img_4, img_5, img_6, 
           img_7, img_8, img_9, img_10, prod_desc, 
           hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
           specifications, flag, 2 AS order_col
    FROM 
        tbl_accessories_list
        WHERE  `product_name` LIKE ? AND `flag` = 1 
    UNION ALL
    SELECT 
        prod_id, r_menu_id AS brand_id, r_sub_id AS modal_id, product_name, billing_name, product_price, 
        offer_price, offer_type, offer_details, arrival_status, stock_status, 
        redirect_url, product_img, img_1, img_2, img_3, img_4, img_5, img_6, 
           img_7, img_8, img_9, img_10, prod_desc, 
           hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
           specifications, flag,3 AS order_col
    FROM 
        tbl_rproduct_list
        WHERE  `product_name` LIKE ? AND `flag` = 1 
    UNION ALL
    SELECT 
        prod_id, h_menu_id AS brand_id, h_submenu_id AS modal_id, product_name, billing_name, product_price, 
        offer_price, offer_type, offer_details, arrival_status, stock_status, 
        redirect_url, product_img,  img_1, img_2, img_3, img_4, img_5, img_6, 
           img_7, img_8, img_9, img_10, prod_desc, 
           hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
           specifications, flag, 4 AS order_col
    FROM 
         tbl_helmet_products
         WHERE  `product_name` LIKE ? AND `flag` = 1 
    UNION ALL
    SELECT 
        prod_id, lug_menu_id AS brand_id, lug_submenu_id AS modal_id, product_name, billing_name, product_price, 
        offer_price, offer_type, offer_details, arrival_status, stock_status, 
        redirect_url, product_img, img_1, img_2, img_3, img_4, img_5, img_6, 
           img_7, img_8, img_9, img_10, prod_desc, 
           hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
           specifications, flag, 5 AS order_col
    FROM 
        tbl_luggagee_products
        WHERE  `product_name` LIKE ? AND `flag` = 1 
    UNION ALL
    SELECT 
        prod_id, camp_menu_id	 AS brand_id, c_submenu_id AS modal_id, product_name, billing_name, product_price, 
        offer_price, offer_type, offer_details, arrival_status, stock_status, 
        redirect_url, product_img, img_1, img_2, img_3, img_4, img_5, img_6, 
           img_7, img_8, img_9, img_10, prod_desc, 
           hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
           specifications, flag,  6 AS order_col
    FROM 
         tbl_camping_products
         WHERE  `product_name` LIKE ? AND `flag` = 1 
    ORDER BY 
        order_col, prod_id";

        $searchPattern = "%$searchData%";
        $searchData = $db->query($query1, [
            $searchPattern,
            $searchPattern,
            $searchPattern,
            $searchPattern,
            $searchPattern,
            $searchPattern
        ])->getResultArray();

        // Pagination calculation
        $page = $this->request->getVar('page') ?? 1;
        $perPage = 12;
        $totalRows = count($searchData);
        $totalPages = ceil($totalRows / $perPage);
        $offset = ($page - 1) * $perPage;

        // Append LIMIT and OFFSET with placeholders
        $query1 .= " LIMIT ? OFFSET ?";

        // Fetch paginated results
        $res['search_data'] = $db->query($query1, [
            $searchPattern,
            $searchPattern,
            $searchPattern,
            $searchPattern,
            $searchPattern,
            $searchPattern,
            $perPage,
            $offset
        ])->getResultArray();



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



        // to get wishlist count prodFilter
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

        return view("searchfiltrView", $res);

    }

    public function searchSuggesstions()
    {
        $db = \Config\Database::connect();
        $searchQuery = $this->request->getGet('query');
        $searchPattern = "%$searchQuery%";

        // Query the database for search suggestions
        $query1 = "SELECT 
        prod_id, brand_id, modal_id, product_name, billing_name, product_price, 
        offer_price, offer_type, offer_details, arrival_status, stock_status, 
        redirect_url, product_img,  img_1, img_2, img_3, img_4, img_5, img_6, 
           img_7, img_8, img_9, img_10, prod_desc, 
           hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
           specifications, flag, 1 AS order_col
    FROM 
         tbl_products
         WHERE  `product_name` LIKE ? AND `flag` = 1 
    UNION ALL
    SELECT 
        prod_id, access_id AS brand_id, sub_access_id AS modal_id, product_name, billing_name, product_price, 
        offer_price, offer_type, offer_details, arrival_status, stock_status, 
        redirect_url, product_img,  img_1, img_2, img_3, img_4, img_5, img_6, 
           img_7, img_8, img_9, img_10, prod_desc, 
           hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
           specifications, flag, 2 AS order_col
    FROM 
        tbl_accessories_list
        WHERE  `product_name` LIKE ? AND `flag` = 1 
    UNION ALL
    SELECT 
        prod_id, r_menu_id AS brand_id, r_sub_id AS modal_id, product_name, billing_name, product_price, 
        offer_price, offer_type, offer_details, arrival_status, stock_status, 
        redirect_url, product_img, img_1, img_2, img_3, img_4, img_5, img_6, 
           img_7, img_8, img_9, img_10, prod_desc, 
           hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
           specifications, flag,3 AS order_col
    FROM 
        tbl_rproduct_list
        WHERE  `product_name` LIKE ? AND `flag` = 1 
    UNION ALL
    SELECT 
        prod_id, h_menu_id AS brand_id, h_submenu_id AS modal_id, product_name, billing_name, product_price, 
        offer_price, offer_type, offer_details, arrival_status, stock_status, 
        redirect_url, product_img,  img_1, img_2, img_3, img_4, img_5, img_6, 
           img_7, img_8, img_9, img_10, prod_desc, 
           hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
           specifications, flag, 4 AS order_col
    FROM 
         tbl_helmet_products
         WHERE  `product_name` LIKE ? AND `flag` = 1 
    UNION ALL
    SELECT 
        prod_id, lug_menu_id AS brand_id, lug_submenu_id AS modal_id, product_name, billing_name, product_price, 
        offer_price, offer_type, offer_details, arrival_status, stock_status, 
        redirect_url, product_img, img_1, img_2, img_3, img_4, img_5, img_6, 
           img_7, img_8, img_9, img_10, prod_desc, 
           hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
           specifications, flag, 5 AS order_col
    FROM 
        tbl_luggagee_products
        WHERE  `product_name` LIKE ? AND `flag` = 1 
    UNION ALL
    SELECT 
        prod_id, camp_menu_id	 AS brand_id, c_submenu_id AS modal_id, product_name, billing_name, product_price, 
        offer_price, offer_type, offer_details, arrival_status, stock_status, 
        redirect_url, product_img, img_1, img_2, img_3, img_4, img_5, img_6, 
           img_7, img_8, img_9, img_10, prod_desc, 
           hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
           specifications, flag,  6 AS order_col
    FROM 
         tbl_camping_products
         WHERE  `product_name` LIKE ? AND `flag` = 1 
    ORDER BY 
        order_col, prod_id  LIMIT 10";

        $searchData = $db->query($query1, [
            $searchPattern,
            $searchPattern,
            $searchPattern,
            $searchPattern,
            $searchPattern,
            $searchPattern
        ])->getResultArray();



        // Return the suggestions as JSON
        return $this->response->setJSON($searchData);
    }

    public function loadmoreSearchFilter()
    {
        $db = \Config\Database::connect();
        $searchValue = $this->request->getPost('search_data');

        // Pagination Settings
        $perPage = 12;

        $query1 = "SELECT 
        prod_id, brand_id, modal_id, product_name, billing_name, product_price, 
        offer_price, offer_type, offer_details, arrival_status, stock_status, 
        redirect_url, product_img,  img_1, img_2, img_3, img_4, img_5, img_6, 
           img_7, img_8, img_9, img_10, prod_desc, 
           hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
           specifications, flag, 1 AS order_col
    FROM 
         tbl_products
         WHERE  `product_name` LIKE ? AND `flag` = 1 
    UNION ALL
    SELECT 
        prod_id, access_id AS brand_id, sub_access_id AS modal_id, product_name, billing_name, product_price, 
        offer_price, offer_type, offer_details, arrival_status, stock_status, 
        redirect_url, product_img,  img_1, img_2, img_3, img_4, img_5, img_6, 
           img_7, img_8, img_9, img_10, prod_desc, 
           hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
           specifications, flag, 2 AS order_col
    FROM 
        tbl_accessories_list
        WHERE  `product_name` LIKE ? AND `flag` = 1 
    UNION ALL
    SELECT 
        prod_id, r_menu_id AS brand_id, r_sub_id AS modal_id, product_name, billing_name, product_price, 
        offer_price, offer_type, offer_details, arrival_status, stock_status, 
        redirect_url, product_img, img_1, img_2, img_3, img_4, img_5, img_6, 
           img_7, img_8, img_9, img_10, prod_desc, 
           hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
           specifications, flag,3 AS order_col
    FROM 
        tbl_rproduct_list
        WHERE  `product_name` LIKE ? AND `flag` = 1 
    UNION ALL
    SELECT 
        prod_id, h_menu_id AS brand_id, h_submenu_id AS modal_id, product_name, billing_name, product_price, 
        offer_price, offer_type, offer_details, arrival_status, stock_status, 
        redirect_url, product_img,  img_1, img_2, img_3, img_4, img_5, img_6, 
           img_7, img_8, img_9, img_10, prod_desc, 
           hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
           specifications, flag, 4 AS order_col
    FROM 
         tbl_helmet_products
         WHERE  `product_name` LIKE ? AND `flag` = 1 
    UNION ALL
    SELECT 
        prod_id, lug_menu_id AS brand_id, lug_submenu_id AS modal_id, product_name, billing_name, product_price, 
        offer_price, offer_type, offer_details, arrival_status, stock_status, 
        redirect_url, product_img, img_1, img_2, img_3, img_4, img_5, img_6, 
           img_7, img_8, img_9, img_10, prod_desc, 
           hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
           specifications, flag, 5 AS order_col
    FROM 
        tbl_luggagee_products
        WHERE  `product_name` LIKE ? AND `flag` = 1 
    UNION ALL
    SELECT 
        prod_id, camp_menu_id	 AS brand_id, c_submenu_id AS modal_id, product_name, billing_name, product_price, 
        offer_price, offer_type, offer_details, arrival_status, stock_status, 
        redirect_url, product_img, img_1, img_2, img_3, img_4, img_5, img_6, 
           img_7, img_8, img_9, img_10, prod_desc, 
           hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
           specifications, flag,  6 AS order_col
    FROM 
         tbl_camping_products
         WHERE  `product_name` LIKE ? AND `flag` = 1 
    ORDER BY 
        order_col, prod_id";

        $searchPattern = "%$searchValue%";
        $searchData = $db->query($query1, [
            $searchPattern,
            $searchPattern,
            $searchPattern,
            $searchPattern,
            $searchPattern,
            $searchPattern
        ])->getResultArray();

        // Pagination calculation
        $page = $this->request->getVar('page') ?? 1;
        $perPage = 12;
        $totalRows = count($searchData);
        $totalPages = ceil($totalRows / $perPage);
        $offset = ($page - 1) * $perPage;

        // Append LIMIT and OFFSET with placeholders
        $query1 .= " LIMIT ? OFFSET ?";

        // Fetch paginated results
        $res['search_data'] = $db->query($query1, [
            $searchPattern,
            $searchPattern,
            $searchPattern,
            $searchPattern,
            $searchPattern,
            $searchPattern,
            $perPage,
            $offset
        ])->getResultArray();

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


        echo json_encode([
            'products' => $res['search_data'],
            'pagination' => $paginationLinks,
            'search_data' => $searchValue
        ]);

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

    // public function getSuggession()
    // {
    //     $db = \Config\Database::connect();
    //     $input = $this->request->getpost("data");
    //     print_r($input);
    //     exit;

    // }

    public function BikeProdFilter($page)
    {
        $db = \Config\Database::connect();
        $request = $this->request;

        // Inputs
        $modalID = $request->getPost('modal_id');
        $brandID = $request->getPost('brand_id');
        $minPrice = $request->getPost('minimum_price');
        $maxPrice = $request->getPost('maximum_price');
        $available = $request->getPost('available');
        $brandFilter = $request->getPost('brand');
        $orderby_web = $request->getPost('orderby_web');
        $orderby_mob = $request->getPost('orderby_mob');
        $discount = $request->getPost('discount');
        $discount_mob = $request->getPost('discount_mob');
        $res = [];


        $prodIDs = [];
        $commonQry = "SELECT prod_id FROM tbl_common_accessories 
                  WHERE flag = 1 
                  AND (FIND_IN_SET(?, modal_name) > 0 OR modal_name = '0') 
                  AND (FIND_IN_SET(?, brand_name) > 0 OR brand_name = '0')";

        $commonProdRows = $db->query($commonQry, [$modalID, $brandID])->getResultArray();

        foreach ($commonProdRows as $row) {
            $prodIDs[] = $row['prod_id'];
        }

        // If no products matched
        if (empty($prodIDs)) {
            echo json_encode([
                'products' => [],
                'pagination' => [],
                'total' => 0
            ]);
            return;
        }

        $query = "SELECT * FROM tbl_accessories_list WHERE flag = 1";
        if (!empty($prodIDs)) {
            $idStr = implode(",", array_map('intval', $prodIDs));
            $query .= " AND prod_id IN ($idStr)";
        }

        if (!empty($minPrice) && !empty($maxPrice)) {
            $query .= " AND offer_price BETWEEN $minPrice AND $maxPrice";
        }

        if (!empty($available)) {
            if (in_array("1", $available)) {
                $query .= " AND quantity > 0";
            } elseif (in_array("0", $available)) {
                $query .= " AND quantity <= 0";
            }
        }

        if (isset($brandFilter) && !empty($brandFilter)) {

            $brandFiltr = array_map([$db, 'escapeString'], $brandFilter);
            $brandFiltr = implode("','", $brandFiltr);
            $query .= " AND search_brand IN('" . $brandFiltr . "')";
        }

        $discVal = ($discount != 0) ? $discount : $discount_mob;
        if ($discVal) {
            $lowDisc = (int) $discVal;
            $highDisc = $lowDisc + 9;
            $query .= " AND offer_details BETWEEN $lowDisc AND $highDisc";
        }

        // Sorting
        $orderby = $orderby_web ?: $orderby_mob;
        switch ($orderby) {
            case 'ASC':
                $query .= " ORDER BY product_name ASC";
                break;
            case 'DESC':
                $query .= " ORDER BY product_name DESC";
                break;
            case 'HIGH':
                $query .= " ORDER BY offer_price DESC";
                break;
            case 'LOW':
                $query .= " ORDER BY offer_price ASC";
                break;
            default:
                $query .= " ORDER BY product_name ASC";
        }

        // Pagination
        $perPage = 20;
        $allResults = $db->query($query)->getResultArray();
        $totalRows = count($allResults);
        $totalPages = ceil($totalRows / $perPage);
        $offset = ($page - 1) * $perPage;

        $paginatedQuery = $query . " LIMIT $perPage OFFSET $offset";
        $resultData = $db->query($paginatedQuery)->getResultArray();

        // Pagination Links
        $paginationLinks = [];
        $maxVisibleLinks = 5;
        $startPage = max(1, $page - floor($maxVisibleLinks / 2));
        $endPage = min($totalPages, $startPage + $maxVisibleLinks - 1);

        if ($startPage > 1) {
            $paginationLinks[] = ['label' => '<<', 'page' => 1];
        }

        if ($page > 1) {
            $paginationLinks[] = ['label' => 'Prev', 'page' => $page - 1];
        }

        for ($i = $startPage; $i <= $endPage; $i++) {
            $paginationLinks[] = [
                'label' => $i,
                'page' => $i,
                'active' => ($i == $page)
            ];
        }

        if ($page < $totalPages) {
            $paginationLinks[] = ['label' => 'Next', 'page' => $page + 1];
        }

        if ($endPage < $totalPages) {
            $paginationLinks[] = ['label' => '>>', 'page' => $totalPages];
        }

        echo json_encode([
            'products' => $resultData,
            'pagination' => $paginationLinks,
            'total' => $totalRows
        ]);
    }



    public function prodFilter($page)
    {

        $pager = \Config\Services::pager();

        $db = \Config\Database::connect();
        $data = $this->request->getPost();


        $minPrice = $this->request->getPost('minimum_price');
        $maxPrice = $this->request->getPost('maximum_price');
        $available = $this->request->getPost('available');
        $brand = $this->request->getPost('brand');
        $orderby_web = $this->request->getPost('orderby_web');
        $orderby_mob = $this->request->getPost('orderby_mob');

        $tablename = $this->request->getPost('tablename');
        $tbl_name = $this->request->getPost('tbl_name');
        $menu_id = (int) $this->request->getPost('menu_id');
        $submenu_id = $this->request->getPost('submenu_id');
        $discount = $this->request->getPost('discount');
        $discount_mob = $this->request->getPost('discount_mob');

        $menu = "false";
        $tableForMenuCheck = !empty($tbl_name) ? $tbl_name : $tablename;
        if ($this->isMenuAndSubmenuActive($tableForMenuCheck, $menu_id, (int) $submenu_id)) {
            $menu = "true";
        }

        if ($menu === "false") {
            echo json_encode([
                'status' => 400,
                'data' => 'This category or subcategory is inactive.',
                'products' => [],
                'pagination' => []
            ]);
            return;
        }



        $submenuMap = [
            "tbl_products" => "modal_id",
            "tbl_accessories_list" => "sub_access_id",
            "tbl_rproduct_list" => "r_sub_id",
            "tbl_helmet_products" => "h_submenu_id",
            "tbl_luggagee_products" => "lug_submenu_id",
            "tbl_camping_products" => "c_submenu_id"
        ];

        $submenu = isset($submenuMap[$tablename]) ? $submenuMap[$tablename] : null;

        $query = "SELECT * FROM $tablename WHERE `flag` = 1 AND $submenu = $submenu_id";


        if (isset($minPrice, $maxPrice) && !empty($minPrice) && !empty($maxPrice)) {
            $query .= "
                AND offer_price BETWEEN '" . $minPrice . "' AND '" . $maxPrice . "'
            ";
        }

        if (isset($available) && !empty($available)) {
            if ($available[0] == 1) {
                $query .= " AND quantity > 0";
            } else if ($available[1] == 0) {
                $query .= " AND quantity <= 0";
            }
        }


        if (isset($brand) && !empty($brand)) {

            $brandFiltr = array_map([$db, 'escapeString'], $brand);
            $brandFiltr = implode("','", $brandFiltr);
            $query .= " AND search_brand IN('" . $brandFiltr . "')";
        }

        if ($discount != 0) {
            $lowDisc = $discount;
            $highDisc = $discount + 9;
            $query .= " AND offer_details>=$lowDisc  AND offer_details <= $highDisc ";
        }


        if ($discount_mob != 0) {
            $lowDisc = $discount_mob;
            $highDisc = $discount_mob + 9;
            $query .= " AND offer_details>=$lowDisc  AND offer_details <= $highDisc ";
        }



        if ($orderby_web == "") {
            $query .= "";
        } else if (isset($orderby_web) && !empty($orderby_web)) {
            if ($orderby_web != 0 || $orderby_web != '') {
                if ($orderby_web == 'ASC') {
                    $orderby_res = $orderby_web;
                    $query .= " ORDER BY product_name ASC";
                } else if ($orderby_web == 'DESC') {
                    $orderby_res = $orderby_web;
                    $query .= " ORDER BY product_name DESC";
                } else if ($orderby_web == 'HIGH') {
                    $orderby_res = $orderby_web;
                    $query .= " ORDER BY offer_price DESC";
                } else if ($orderby_web == 'LOW') {
                    $orderby_res = $orderby_web;
                    $query .= " ORDER BY offer_price ASC";
                }
            }

        }

        if ($orderby_mob == "") {
            $query .= "";
        } else if (isset($orderby_mob) && !empty($orderby_mob)) {
            if ($orderby_mob != 0 || $orderby_mob != '') {
                if ($orderby_mob == 'ASC') {
                    $orderby_res = $orderby_mob;
                    $query .= " ORDER BY product_name ASC";
                } else if ($orderby_mob == 'DESC') {
                    $orderby_res = $orderby_mob;
                    $query .= " ORDER BY product_name DESC";
                } else if ($orderby_mob == 'HIGH') {
                    $orderby_res = $orderby_mob;
                    $query .= " ORDER BY offer_price DESC";
                } else if ($orderby_mob == 'LOW') {
                    $orderby_res = $orderby_mob;
                    $query .= " ORDER BY offer_price ASC";
                }
            }
        }

        // Pagination Settings
        $perPage = 12;
        $totalRows = $db->query($query)->getNumRows();
        $totalPages = ceil($totalRows / $perPage);

        // Handle Page Offset
        $offset = ($page - 1) * $perPage;
        $query .= " LIMIT $perPage OFFSET $offset";


        $resultData = $db->query($query)->getResultArray();

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

        // $datasss = [
        //     'products' => $resultData,
        //     'pagination' => $paginationLinks
        // ];
        // echo "<pre>";
        // print_r($datasss);
        // die;

        echo json_encode([
            'products' => $resultData,
            'pagination' => $paginationLinks
        ]);

    }

    private function isMenuAndSubmenuActive($tableName, $menuId, $submenuId)
    {
        $db = \Config\Database::connect();

        if ($tableName === 'tbl_helmet_products') {
            if (empty($menuId) || empty($submenuId)) {
                return false;
            }

            $menuActive = $db->query(
                "SELECT h_menu_id FROM tbl_helmet_menu WHERE h_menu_id = ? AND flag = 1 AND is_active = 1 LIMIT 1",
                [$menuId]
            )->getRowArray();
            $submenuActive = $db->query(
                "SELECT h_submenu_id FROM tbl_helmet_submenu WHERE h_submenu_id = ? AND h_menu_id = ? AND flag = 1 AND is_active = 1 LIMIT 1",
                [$submenuId, $menuId]
            )->getRowArray();

            return !empty($menuActive) && !empty($submenuActive);
        }

        if ($tableName === 'tbl_accessories_list') {
            if (empty($menuId) || empty($submenuId)) {
                return false;
            }

            $menuActive = $db->query(
                "SELECT access_id FROM tbl_access_master WHERE access_id = ? AND flag = 1 AND is_active = 1 LIMIT 1",
                [$menuId]
            )->getRowArray();
            $submenuActive = $db->query(
                "SELECT sub_access_id FROM tbl_subaccess_master WHERE sub_access_id = ? AND access_id = ? AND flag = 1 AND is_active = 1 LIMIT 1",
                [$submenuId, $menuId]
            )->getRowArray();

            return !empty($menuActive) && !empty($submenuActive);
        }

        if ($tableName === 'tbl_camping_products') {
            if (empty($menuId) || empty($submenuId)) {
                return false;
            }

            $menuActive = $db->query(
                "SELECT camp_menu_id FROM tbl_camping_menu WHERE camp_menu_id = ? AND flag = 1 AND is_active = 1 LIMIT 1",
                [$menuId]
            )->getRowArray();
            $submenuActive = $db->query(
                "SELECT c_submenu_id FROM tbl_camping_submenu WHERE c_submenu_id = ? AND camp_menuid = ? AND flag = 1 AND is_active = 1 LIMIT 1",
                [$submenuId, $menuId]
            )->getRowArray();

            return !empty($menuActive) && !empty($submenuActive);
        }

        if ($tableName === 'tbl_luggagee_products') {
            if (empty($menuId) || empty($submenuId)) {
                return false;
            }

            $menuActive = $db->query(
                "SELECT lug_menu_id FROM tbl_luggage_menu WHERE lug_menu_id = ? AND flag = 1 AND is_active = 1 LIMIT 1",
                [$menuId]
            )->getRowArray();
            $submenuActive = $db->query(
                "SELECT lug_submenu_id FROM tbl_luggage_submenu WHERE lug_submenu_id = ? AND lug_menu_id = ? AND flag = 1 AND is_active = 1 LIMIT 1",
                [$submenuId, $menuId]
            )->getRowArray();

            return !empty($menuActive) && !empty($submenuActive);
        }

        if ($tableName === 'tbl_rproduct_list') {
            if (empty($menuId) || empty($submenuId)) {
                return false;
            }

            $menuActive = $db->query(
                "SELECT r_menu_id FROM tbl_riding_menu WHERE r_menu_id = ? AND flag = 1 AND is_active = 1 LIMIT 1",
                [$menuId]
            )->getRowArray();
            $submenuActive = $db->query(
                "SELECT r_sub_id FROM tbl_riding_submenu WHERE r_sub_id = ? AND r_menu_id = ? AND flag = 1 AND is_active = 1 LIMIT 1",
                [$submenuId, $menuId]
            )->getRowArray();

            return !empty($menuActive) && !empty($submenuActive);
        }

        return true;
    }


    public function offersFilter($page)
    {

        $db = \Config\Database::connect();
        $data = $this->request->getPost();


        $minPrice = $this->request->getPost('minimum_price');
        $maxPrice = $this->request->getPost('maximum_price');
        $available = $this->request->getPost('available');
        $brand = $this->request->getPost('brand');
        $discount = $this->request->getPost('discount');
        $discount_mob = $this->request->getPost('discount_mob');
        $orderby_web = $this->request->getPost('orderby_web');
        $orderby_mob = $this->request->getPost('orderby_mob');


        $query = "
        SELECT prod_id, brand_id, modal_id, product_name, billing_name, product_price, 
               offer_price, offer_type, offer_details, arrival_status, stock_status, 
               redirect_url, product_img, img_1, img_2, img_3, img_4, img_5, img_6, 
               img_7, img_8, img_9, img_10, prod_desc, hot_sale, tbl_name, search_brand, 
               weight, weight_units, quantity, specifications, flag
        FROM tbl_products
        WHERE flag = 1 AND offer_type = 0 AND quantity > 0
        " . $this->buildAdditionalConditions($minPrice, $maxPrice, $available, $brand, 'tbl_products', $discount, $discount_mob) . "
        UNION ALL
        SELECT prod_id, access_id AS brand_id, sub_access_id AS modal_id, product_name, 
               billing_name, product_price, offer_price, offer_type, offer_details, 
               arrival_status, stock_status, redirect_url, product_img, img_1, img_2, 
               img_3, img_4, img_5, img_6, img_7, img_8, img_9, img_10, prod_desc, 
               hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
               specifications, flag
        FROM tbl_accessories_list
        WHERE flag = 1 AND offer_type = 0
        " . $this->buildAdditionalConditions($minPrice, $maxPrice, $available, $brand, 'tbl_accessories_list', $discount, $discount_mob) . "
        UNION ALL
        SELECT prod_id, r_menu_id AS brand_id, r_sub_id AS modal_id, product_name, 
               billing_name, product_price, offer_price, offer_type, offer_details, 
               arrival_status, stock_status, redirect_url, product_img, img_1, img_2, 
               img_3, img_4, img_5, img_6, img_7, img_8, img_9, img_10, prod_desc, 
               hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
               specifications, flag
        FROM tbl_rproduct_list
        WHERE flag = 1 AND offer_type = 0
        " . $this->buildAdditionalConditions($minPrice, $maxPrice, $available, $brand, 'tbl_rproduct_list', $discount, $discount_mob) . "
        UNION ALL
        SELECT prod_id, h_menu_id AS brand_id, h_submenu_id AS modal_id, product_name, 
               billing_name, product_price, offer_price, offer_type, offer_details, 
               arrival_status, stock_status, redirect_url, product_img, img_1, img_2, 
               img_3, img_4, img_5, img_6, img_7, img_8, img_9, img_10, prod_desc, 
               hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
               specifications, flag
        FROM tbl_helmet_products
        WHERE flag = 1 AND offer_type = 0
        " . $this->buildAdditionalConditions($minPrice, $maxPrice, $available, $brand, 'tbl_helmet_products', $discount, $discount_mob) . "
        UNION ALL
        SELECT prod_id, lug_menu_id AS brand_id, lug_submenu_id AS modal_id, product_name, 
               billing_name, product_price, offer_price, offer_type, offer_details, 
               arrival_status, stock_status, redirect_url, product_img, img_1, img_2, 
               img_3, img_4, img_5, img_6, img_7, img_8, img_9, img_10, prod_desc, 
               hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
               specifications, flag
        FROM tbl_luggagee_products
        WHERE flag = 1 AND offer_type = 0
        " . $this->buildAdditionalConditions($minPrice, $maxPrice, $available, $brand, 'tbl_luggagee_products', $discount, $discount_mob) . "
        UNION ALL
        SELECT prod_id, camp_menu_id AS brand_id, c_submenu_id AS modal_id, product_name, 
               billing_name, product_price, offer_price, offer_type, offer_details, 
               arrival_status, stock_status, redirect_url, product_img, img_1, img_2, 
               img_3, img_4, img_5, img_6, img_7, img_8, img_9, img_10, prod_desc, 
               hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
               specifications, flag
        FROM tbl_camping_products
        WHERE flag = 1 AND offer_type = 0
        " . $this->buildAdditionalConditions($minPrice, $maxPrice, $available, $brand, 'tbl_camping_products', $discount, $discount_mob) . "
    ";

        if (!empty($orderby_web)) {
            switch ($orderby_web) {
                case 'ASC':
                    $query .= " ORDER BY product_name ASC";
                    break;
                case 'DESC':
                    $query .= " ORDER BY product_name DESC";
                    break;
                case 'HIGH':
                    $query .= " ORDER BY offer_price DESC";
                    break;
                case 'LOW':
                    $query .= " ORDER BY offer_price ASC";
                    break;
            }
        }

        if (!empty($orderby_mob)) {
            switch ($orderby_mob) {
                case 'ASC':
                    $query .= " ORDER BY product_name ASC";
                    break;
                case 'DESC':
                    $query .= " ORDER BY product_name DESC";
                    break;
                case 'HIGH':
                    $query .= " ORDER BY offer_price DESC";
                    break;
                case 'LOW':
                    $query .= " ORDER BY offer_price ASC";
                    break;
            }
        }


        $totalDatas = $db->query($query)->getResultArray();


        // Pagination Settings
        $perPage = 12;
        $totalRows = count($totalDatas);

        $totalPages = ceil($totalRows / $perPage);

        // Handle Page Offset
        $offset = ($page - 1) * $perPage;
        $query .= " LIMIT $perPage OFFSET $offset";
        $resultData = $db->query($query)->getResultArray();


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

        echo json_encode([
            'products' => $resultData,
            'pagination' => $paginationLinks
        ]);

    }


    // filter function for all tables
    private function buildAdditionalConditions($minPrice, $maxPrice, $available, $brand, $tableAlias, $discount, $discount_mob)
    {
        $conditions = "";
        if (isset($minPrice, $maxPrice) && !empty($minPrice) && !empty($maxPrice)) {
            $conditions .= " AND {$tableAlias}.offer_price BETWEEN {$minPrice} AND {$maxPrice}";
        }
        if (isset($available) && !empty($available)) {

            if ($available[0] == 1) {
                $availableCondition = " > 0";
            } else if ($available[0] == 0) {
                $availableCondition = " <= 0";
            }

            $conditions .= " AND {$tableAlias}.quantity {$availableCondition}";
        }
        if (isset($brand) && !empty($brand)) {
            $placeholders = implode("','", $brand);
            $conditions .= " AND {$tableAlias}.search_brand IN ('{$placeholders}')";
        }
        if (isset($discount) && !empty($discount)) {

            $lowDisc = $discount;
            $highDisc = $discount + 9;
            $conditions .= " AND offer_details>=$lowDisc  AND offer_details <= $highDisc ";
        }
        if (isset($discount_mob) && !empty($discount_mob)) {

            $lowDisc = $discount_mob;
            $highDisc = $discount_mob + 9;
            $conditions .= " AND offer_details>=$lowDisc  AND offer_details <= $highDisc ";
        }

        return $conditions;
    }


    public function newArrivalFilter($page)
    {

        $db = \Config\Database::connect();
        $minPrice = $this->request->getPost('minimum_price');
        $maxPrice = $this->request->getPost('maximum_price');
        $available = $this->request->getPost('available');
        $brand = $this->request->getPost('brand');
        $discount = $this->request->getPost('discount');
        $discount_mob = $this->request->getPost('discount_mob');
        $orderby_web = $this->request->getPost('orderby_web');
        $orderby_mob = $this->request->getPost('orderby_mob');


        $query = "
    SELECT prod_id, brand_id, modal_id, product_name, billing_name, product_price, 
           offer_price, offer_type, offer_details, arrival_status, stock_status, 
           redirect_url, product_img, img_1, img_2, img_3, img_4, img_5, img_6, 
           img_7, img_8, img_9, img_10, prod_desc, hot_sale, tbl_name, search_brand, 
           weight, weight_units, quantity, specifications, flag
    FROM tbl_products
    WHERE flag = 1 AND arrival_status = 1 
    " . $this->buildAdditionalConditions($minPrice, $maxPrice, $available, $brand, 'tbl_products', $discount, $discount_mob) . "
    UNION ALL
    SELECT prod_id, access_id AS brand_id, sub_access_id AS modal_id, product_name, 
           billing_name, product_price, offer_price, offer_type, offer_details, 
           arrival_status, stock_status, redirect_url, product_img, img_1, img_2, 
           img_3, img_4, img_5, img_6, img_7, img_8, img_9, img_10, prod_desc, 
           hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
           specifications, flag
    FROM tbl_accessories_list
    WHERE flag = 1 AND arrival_status = 1 
    " . $this->buildAdditionalConditions($minPrice, $maxPrice, $available, $brand, 'tbl_accessories_list', $discount, $discount_mob) . "
    UNION ALL
    SELECT prod_id, r_menu_id AS brand_id, r_sub_id AS modal_id, product_name, 
           billing_name, product_price, offer_price, offer_type, offer_details, 
           arrival_status, stock_status, redirect_url, product_img, img_1, img_2, 
           img_3, img_4, img_5, img_6, img_7, img_8, img_9, img_10, prod_desc, 
           hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
           specifications, flag
    FROM tbl_rproduct_list
    WHERE flag = 1 AND arrival_status = 1 
    " . $this->buildAdditionalConditions($minPrice, $maxPrice, $available, $brand, 'tbl_rproduct_list', $discount, $discount_mob) . "
    UNION ALL
    SELECT prod_id, h_menu_id AS brand_id, h_submenu_id AS modal_id, product_name, 
           billing_name, product_price, offer_price, offer_type, offer_details, 
           arrival_status, stock_status, redirect_url, product_img, img_1, img_2, 
           img_3, img_4, img_5, img_6, img_7, img_8, img_9, img_10, prod_desc, 
           hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
           specifications, flag
    FROM tbl_helmet_products
    WHERE flag = 1 AND arrival_status = 1 
    " . $this->buildAdditionalConditions($minPrice, $maxPrice, $available, $brand, 'tbl_helmet_products', $discount, $discount_mob) . "
    UNION ALL
    SELECT prod_id, lug_menu_id AS brand_id, lug_submenu_id AS modal_id, product_name, 
           billing_name, product_price, offer_price, offer_type, offer_details, 
           arrival_status, stock_status, redirect_url, product_img, img_1, img_2, 
           img_3, img_4, img_5, img_6, img_7, img_8, img_9, img_10, prod_desc, 
           hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
           specifications, flag
    FROM tbl_luggagee_products
    WHERE flag = 1 AND arrival_status = 1 
    " . $this->buildAdditionalConditions($minPrice, $maxPrice, $available, $brand, 'tbl_luggagee_products', $discount, $discount_mob) . "
    UNION ALL
    SELECT prod_id, camp_menu_id AS brand_id, c_submenu_id AS modal_id, product_name, 
           billing_name, product_price, offer_price, offer_type, offer_details, 
           arrival_status, stock_status, redirect_url, product_img, img_1, img_2, 
           img_3, img_4, img_5, img_6, img_7, img_8, img_9, img_10, prod_desc, 
           hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
           specifications, flag
    FROM tbl_camping_products
    WHERE flag = 1 AND arrival_status = 1 
    " . $this->buildAdditionalConditions($minPrice, $maxPrice, $available, $brand, 'tbl_camping_products', $discount, $discount_mob) . "
";

        if (!empty($orderby_web)) {
            switch ($orderby_web) {
                case 'ASC':
                    $query .= " ORDER BY product_name ASC";
                    break;
                case 'DESC':
                    $query .= " ORDER BY product_name DESC";
                    break;
                case 'HIGH':
                    $query .= " ORDER BY offer_price DESC";
                    break;
                case 'LOW':
                    $query .= " ORDER BY offer_price ASC";
                    break;
            }
        }

        if (!empty($orderby_mob)) {
            switch ($orderby_mob) {
                case 'ASC':
                    $query .= " ORDER BY product_name ASC";
                    break;
                case 'DESC':
                    $query .= " ORDER BY product_name DESC";
                    break;
                case 'HIGH':
                    $query .= " ORDER BY offer_price DESC";
                    break;
                case 'LOW':
                    $query .= " ORDER BY offer_price ASC";
                    break;
            }
        }


        $totalDatas = $db->query($query)->getResultArray();


        // Pagination Settings
        $perPage = 12;
        $totalRows = count($totalDatas);

        $totalPages = ceil($totalRows / $perPage);

        // Handle Page Offset
        $offset = ($page - 1) * $perPage;
        $query .= " LIMIT $perPage OFFSET $offset";
        $resultData = $db->query($query)->getResultArray();


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

        echo json_encode([
            'products' => $resultData,
            'pagination' => $paginationLinks
        ]);

    }

    public function hotsaleFilter($page)
    {

        $db = \Config\Database::connect();
        $minPrice = $this->request->getPost('minimum_price');
        $maxPrice = $this->request->getPost('maximum_price');
        $available = $this->request->getPost('available');
        $brand = $this->request->getPost('brand');
        $orderby = $this->request->getPost('orderby');
        $tablename = $this->request->getPost('tablename');
        $discount = $this->request->getPost('discount');
        $discount_mob = $this->request->getPost('discount_mob');
        $orderby_web = $this->request->getPost('orderby_web');
        $orderby_mob = $this->request->getPost('orderby_mob');

        $query = "
        SELECT prod_id, brand_id, modal_id, product_name, billing_name, product_price, 
               offer_price, offer_type, offer_details, arrival_status, stock_status, 
               redirect_url, product_img, img_1, img_2, img_3, img_4, img_5, img_6, 
               img_7, img_8, img_9, img_10, prod_desc, hot_sale, tbl_name, search_brand, 
               weight, weight_units, quantity, specifications, flag
        FROM tbl_products
        WHERE  (hot_sale = 1 OR offer_type = 0) AND flag = 1 
        " . $this->buildAdditionalConditions($minPrice, $maxPrice, $available, $brand, 'tbl_products', $discount, $discount_mob) . "
        UNION ALL
        SELECT prod_id, access_id AS brand_id, sub_access_id AS modal_id, product_name, 
               billing_name, product_price, offer_price, offer_type, offer_details, 
               arrival_status, stock_status, redirect_url, product_img, img_1, img_2, 
               img_3, img_4, img_5, img_6, img_7, img_8, img_9, img_10, prod_desc, 
               hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
               specifications, flag
        FROM tbl_accessories_list
        WHERE  (hot_sale = 1 OR offer_type = 0) AND flag = 1 
        " . $this->buildAdditionalConditions($minPrice, $maxPrice, $available, $brand, 'tbl_accessories_list', $discount, $discount_mob) . "
        UNION ALL
        SELECT prod_id, r_menu_id AS brand_id, r_sub_id AS modal_id, product_name, 
               billing_name, product_price, offer_price, offer_type, offer_details, 
               arrival_status, stock_status, redirect_url, product_img, img_1, img_2, 
               img_3, img_4, img_5, img_6, img_7, img_8, img_9, img_10, prod_desc, 
               hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
               specifications, flag
        FROM tbl_rproduct_list
        WHERE  (hot_sale = 1 OR offer_type = 0) AND flag = 1 
        " . $this->buildAdditionalConditions($minPrice, $maxPrice, $available, $brand, 'tbl_rproduct_list', $discount, $discount_mob) . "
        UNION ALL
        SELECT prod_id, h_menu_id AS brand_id, h_submenu_id AS modal_id, product_name, 
               billing_name, product_price, offer_price, offer_type, offer_details, 
               arrival_status, stock_status, redirect_url, product_img, img_1, img_2, 
               img_3, img_4, img_5, img_6, img_7, img_8, img_9, img_10, prod_desc, 
               hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
               specifications, flag
        FROM tbl_helmet_products
        WHERE  (hot_sale = 1 OR offer_type = 0) AND flag = 1 
        " . $this->buildAdditionalConditions($minPrice, $maxPrice, $available, $brand, 'tbl_helmet_products', $discount, $discount_mob) . "
        UNION ALL
        SELECT prod_id, lug_menu_id AS brand_id, lug_submenu_id AS modal_id, product_name, 
               billing_name, product_price, offer_price, offer_type, offer_details, 
               arrival_status, stock_status, redirect_url, product_img, img_1, img_2, 
               img_3, img_4, img_5, img_6, img_7, img_8, img_9, img_10, prod_desc, 
               hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
               specifications, flag
        FROM tbl_luggagee_products
        WHERE  (hot_sale = 1 OR offer_type = 0) AND flag = 1 
        " . $this->buildAdditionalConditions($minPrice, $maxPrice, $available, $brand, 'tbl_luggagee_products', $discount, $discount_mob) . "
        UNION ALL
        SELECT prod_id, camp_menu_id AS brand_id, c_submenu_id AS modal_id, product_name, 
               billing_name, product_price, offer_price, offer_type, offer_details, 
               arrival_status, stock_status, redirect_url, product_img, img_1, img_2, 
               img_3, img_4, img_5, img_6, img_7, img_8, img_9, img_10, prod_desc, 
               hot_sale, tbl_name, search_brand, weight, weight_units, quantity, 
               specifications, flag
        FROM tbl_camping_products
        WHERE  (hot_sale = 1 OR offer_type = 0) AND flag = 1 
        " . $this->buildAdditionalConditions($minPrice, $maxPrice, $available, $brand, 'tbl_camping_products', $discount, $discount_mob) . "
    ";

        if (!empty($orderby_web)) {
            switch ($orderby_web) {
                case 'ASC':
                    $query .= " ORDER BY product_name ASC";
                    break;
                case 'DESC':
                    $query .= " ORDER BY product_name DESC";
                    break;
                case 'HIGH':
                    $query .= " ORDER BY offer_price DESC";
                    break;
                case 'LOW':
                    $query .= " ORDER BY offer_price ASC";
                    break;
            }
        }

        if (!empty($orderby_mob)) {
            switch ($orderby_mob) {
                case 'ASC':
                    $query .= " ORDER BY product_name ASC";
                    break;
                case 'DESC':
                    $query .= " ORDER BY product_name DESC";
                    break;
                case 'HIGH':
                    $query .= " ORDER BY offer_price DESC";
                    break;
                case 'LOW':
                    $query .= " ORDER BY offer_price ASC";
                    break;
            }
        }


        $totalDatas = $db->query($query)->getResultArray();


        // Pagination Settings
        $perPage = 12;
        $totalRows = count($totalDatas);

        $totalPages = ceil($totalRows / $perPage);

        // Handle Page Offset
        $offset = ($page - 1) * $perPage;
        $query .= " LIMIT $perPage OFFSET $offset";
        $resultData = $db->query($query)->getResultArray();


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

        echo json_encode([
            'products' => $resultData,
            'pagination' => $paginationLinks
        ]);
    }

    public function brandFilter()
    {

        $db = \Config\Database::connect();
        $minPrice = $this->request->getPost('minimum_price');
        $maxPrice = $this->request->getPost('maximum_price');
        $available = $this->request->getPost('available');
        $brand = $this->request->getPost('brand');
        $orderby = $this->request->getPost('orderby');



        $query = "SELECT *
        FROM (
            SELECT *, offer_type AS otype , offer_price AS oprice
            FROM tbl_products
            WHERE flag = 1 
            " . $this->buildAdditionalConditions($minPrice, $maxPrice, $available, $brand, 'tbl_products') . "
            
            UNION ALL
            
            SELECT *, offer_type AS otype , offer_price AS oprice
            FROM tbl_accessories_list
            WHERE flag = 1 
            " . $this->buildAdditionalConditions($minPrice, $maxPrice, $available, $brand, 'tbl_accessories_list') . "
            
            UNION ALL
            
            SELECT *, offer_type AS otype , offer_price AS oprice
            FROM tbl_helmet_products
            WHERE flag = 1 
            " . $this->buildAdditionalConditions($minPrice, $maxPrice, $available, $brand, 'tbl_helmet_products') . "
            
            UNION ALL
            
            SELECT *, offer_type AS otype , offer_price AS oprice
            FROM tbl_luggagee_products
            WHERE flag = 1 
            " . $this->buildAdditionalConditions($minPrice, $maxPrice, $available, $brand, 'tbl_luggagee_products') . "
            
            UNION ALL
            
            SELECT *, offer_type AS otype , offer_price AS oprice
            FROM tbl_rproduct_list
            WHERE flag = 1 
            " . $this->buildAdditionalConditions($minPrice, $maxPrice, $available, $brand, 'tbl_rproduct_list') . "
            
            UNION ALL
            
            SELECT *, offer_type AS otype , offer_price AS oprice
            FROM tbl_camping_products
            WHERE flag = 1 
            " . $this->buildAdditionalConditions($minPrice, $maxPrice, $available, $brand, 'tbl_camping_products') . "
        ) AS combined_results
    ";
        if (!empty($orderby)) {
            $query .= " ORDER BY product_name {$orderby}";
        }
        $resultData = $db->query($query)->getResultArray();
        echo json_encode($resultData);
    }
}
