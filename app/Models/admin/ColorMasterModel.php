<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class ColorMasterModel extends Model
{
    protected $table = 'tbl_color';
    protected $primaryKey = 'color_id';
    protected $allowedFields = ['color_name', 'hex_code'];
}