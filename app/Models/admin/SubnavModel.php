<?php
namespace App\Models\admin;

use CodeIgniter\Model;

class SubnavModel extends Model
{
    protected $table = 'tbl_subnav_master';
    protected $primaryKey = 'subnav_id';
    protected $allowedFields = ['nav_id', 'sub_navbar'];
}