<?php
namespace App\Models\admin;

use CodeIgniter\Model;

class SubMenuModel extends Model
{
    protected $table = 'tbl_submenu_master';
    protected $primaryKey = 'sub_menu_id';
    protected $allowedFields = ['subnav_id', 'sub_menu'];
}