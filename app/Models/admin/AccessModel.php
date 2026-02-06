<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class AccessModel extends Model
{
    protected $table = 'tbl_access_master';
    protected $primaryKey = 'access_id';
    protected $allowedFields = [
        'access_title',
    ];
}