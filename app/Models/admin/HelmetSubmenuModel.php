<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class HelmetSubmenuModel extends Model
{
    protected $table = 'tbl_helmet_submenu';
    protected $primaryKey = 'h_submenu_id';
    protected $allowedFields = ['h_menu_id', 'h_submenu', 'hsubmenu_img'];
}