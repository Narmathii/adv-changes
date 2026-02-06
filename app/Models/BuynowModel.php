<?php

namespace App\Models;

use CodeIgniter\Model;

class BuynowModel extends Model
{

    protected $table = 'tbl_buynow';
    protected $primaryKey = 'buynow_id';
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
      


    ];
}