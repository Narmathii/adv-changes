<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class ProdConfigModel extends Model
{
    protected $table = 'tbl_configuration';
    protected $primaryKey = 'config_id';
    protected $allowedFields = [
        'prod_id',
        'tbl_name',
        'colour',
        'size',
        'soldout_status',
        'config_img1',
        'config_img2',
        'config_img3',
        'config_img4'

    ];


}