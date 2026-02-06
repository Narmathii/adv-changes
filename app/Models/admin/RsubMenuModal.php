<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class RsubMenuModal extends Model
{
    protected $table = 'tbl_riding_submenu';
    protected $primaryKey = 'r_sub_id';
    protected $allowedFields = ['r_menu_id', 'r_sub_menu'];
}