<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class ProductsModel extends Model
{
    protected $table = 'tbl_products_main';
    protected $primaryKey = 'prod_id';
    protected $allowedFields = [
        'brand_id',
        'modal_id',
        'sub_access_id',
        'product_name',
        'product_price',
        'offer_details',
        'arrival_id',
        'soldout_id',
        'product_img',
        'img_1',
        'img_2',
        'img_3',
        'img_4',
        'prod_desc',
        'material',
        'colour',
        'prod_weight',
        'measurement',
        'fitment',
        'warrenty',
        'features'

    ];


}