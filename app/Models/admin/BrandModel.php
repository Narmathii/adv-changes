<?php
namespace App\Models\admin;

use CodeIgniter\Model;

class BrandModel extends Model
{
    protected $table = 'tbl_brand_master';
    protected $primaryKey = 'brand_id';
    protected $allowedFields = ['brand_name', 'brand_img'];
}