<?php
namespace App\Models\admin;

use CodeIgniter\Model;

class BrandMasterModel extends Model
{
    protected $table = 'brand_master';
    protected $primaryKey = 'brand_master_id';
    protected $allowedFields = ['brand_name', 'brand_img', 'offer_percentage'];
}