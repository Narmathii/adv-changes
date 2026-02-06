<?php

namespace App\Models;

use CodeIgniter\Model;

class FrequentModel extends Model
{

    protected $table = 'frequent_products';
    protected $primaryKey = 'frequent_id';
    protected $allowedFields = [
        'product_id',
        'tbl_name',
        'prod_count',
        'user'

    ];
}