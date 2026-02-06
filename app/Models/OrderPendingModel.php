<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderPendingModel extends Model
{

    protected $table = 'payment_orderpending_log';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'order_id',
        'user_id',
        'rzporder_id',
        'order_pending_log',
    ];
}