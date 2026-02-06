<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class CampMenuModel extends Model
{
    protected $table = 'tbl_camping_menu';
    protected $primaryKey = 'camp_menu_id';
    protected $allowedFields = ['camp_menu'];
}