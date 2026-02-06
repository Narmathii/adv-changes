<?php
namespace App\Models\admin;

use CodeIgniter\Model;

class SubAccessModel extends Model
{
    protected $table = 'tbl_subaccess_master';
    protected $primaryKey = 'sub_access_id ';
    protected $allowedFields = ['access_id', 'sub_access_name'];
}