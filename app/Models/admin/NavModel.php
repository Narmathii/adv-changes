<?php
namespace App\Models\admin;

use CodeIgniter\Model;

class NavModel extends Model
{

    protected $table = 'tbl_nav_master';
    protected $primaryKey = 'nav_id';
    protected $allowedFields = ['nav_title'];
}