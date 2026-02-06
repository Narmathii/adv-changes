<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class CourierModel extends Model
{

    protected $table = 'tbl_couriers';
    protected $primaryKey = 'courier_id';
    protected $allowedFields = [
        'courier_name',
        'c_url',

    ];

}