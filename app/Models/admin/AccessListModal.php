<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class AccessListModal extends Model
{
    protected $table = 'tbl_accessories_list';
    protected $primaryKey = 'prod_id';
    protected $useTimestamps = true;
    protected $createdField = 'timestamp';
    protected $updatedField = 'updated_at';
    protected $allowedFields = [
        'access_id',
        'sub_access_id',
        'billing_name',
        'product_name',
        'product_price',
        'offer_type',
        'offer_price',
        'stock_status',
        'offer_details',
        'arrival_status',
        'redirect_url',
        'product_img',
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