<?php
namespace App\Models\admin;

use CodeIgniter\Model;

class BannerModal extends Model
{
    protected $table = 'tbl_banner';
    protected $primaryKey = 'banner_id';
    protected $allowedFields = ['mobile_img', 'desktop_img','link'];
}