<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class CourierChargeModel extends Model
{
    protected $table = 'tbl_courier_charges';
    protected $primaryKey = 'charge_id';
    protected $allowedFields = [
        'courier_id',
        'state_id',
        'dist_id',
        'charges',
        'comments',
        'active_sts'

    ];
}