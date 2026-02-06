<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class HelmetMenuModel extends Model
{
    protected $table = 'tbl_helmet_menu';
    protected $primaryKey = 'h_menu_id';
    protected $allowedFields = ['h_menu'];
}