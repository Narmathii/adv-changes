<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class RproductModal extends Model
{
    protected $table = 'tbl_rproduct_list';
    protected $primaryKey = 'prod_id';
    protected $allowedFields = [
        'r_menu_id',
        'r_sub_id',
        'billing_name',
        'product_name',
        'product_price',
        'offer_price',
        'offer_details',
        'arrival_status',
        'stock_status',
        'redirect_url',
        'product_img',
        'offer_type',
        'img_1',
        'img_2',
        'img_3',
        'img_4',
        'img_5',
        'img_6',
        'img_7',
        'img_8',
        'img_9',
        'img_10',
        'prod_desc',
        'hot_sale',
        'tbl_name',
        'search_brand',
        'weight',
        'weight_units',
        'quantity',
        'specifications',
        'drop_shipping'

    ];


}