<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class CampSubmenuModel extends Model
{
    protected $table = 'tbl_camping_submenu';
    protected $primaryKey = 'c_submenu_id';
    protected $allowedFields = ['camp_menuid', 'c_submenu', 'csubmenu_img'];
}