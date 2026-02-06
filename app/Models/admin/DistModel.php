<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class DistModel extends Model
{
    protected $table = 'tbl_district';
    protected $primaryKey = 'dist_id';
    protected $allowedFields = [
        'state_id',
        'dist_name'
    ];
}