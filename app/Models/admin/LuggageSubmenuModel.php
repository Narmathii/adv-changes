<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class LuggageSubmenuModel extends Model
{
    protected $table = 'tbl_luggage_submenu';
    protected $primaryKey = 'lug_submenu_id';
    protected $allowedFields = ['lug_menu_id','lug_submenu'];
}