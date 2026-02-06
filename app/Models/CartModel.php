<?php

namespace App\Models;

use CodeIgniter\Model;

class CartModel extends Model
{

    protected $table = 'tbl_user_cart';
    protected $primaryKey = 'cart_id';
    protected $allowedFields = [
        'user_id',
        'table_name',
        'prod_id',
        'quantity',
        'prod_price',
        'sub_total',
        'color',
        'hex_code',
        'size',
        'config_image1',
        'size_stock'

    ];
}