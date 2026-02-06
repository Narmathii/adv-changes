<?php

namespace App\Models;

use CodeIgniter\Model;

class AddressModel extends Model
{

    protected $table = 'tbl_user_address';
    protected $primaryKey = 'add_id';
    protected $allowedFields = [

        'user_id',
        'state_id',
        'dist_id',
        'landmark',
        'city',
        'address',
        'pincode',
        'default_addr'
    ];

}