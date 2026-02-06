<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class ComboModel extends Model
{
    protected $table = 'tbl_combo_product';
    protected $primaryKey = 'prod_id';
    protected $allowedFields = [
        'product_name',
        'product_price',
        'offer_price',
        'offer_details',
        'arrival_status',
        'soldout_status',
        'redirect_url',
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