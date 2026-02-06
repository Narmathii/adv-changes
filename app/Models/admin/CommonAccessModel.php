<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class CommonAccessModel extends Model
{
    protected $table = 'tbl_common_accessories';
    protected $primaryKey = 'common_id';
    protected $allowedFields = [
        'prod_id',
        'brand_name',
        'modal_name'
    ];
}