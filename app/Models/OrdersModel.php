<?php

namespace App\Models;

use CodeIgniter\Model;

class OrdersModel extends Model
{

    protected $table = 'tbl_orders';
    protected $primaryKey = 'order_id';
    protected $allowedFields = [
        'order_no',
        'user_id',
        'sub_total',
        'add_id',
        'order_status',
        'order_date',
        'delivery_date',
        'delivery_message',
        'courier_charge',
        'courier_type',
        'drop_shipping',
        'order_time'

    ];
}