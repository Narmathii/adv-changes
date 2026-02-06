<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentRequestLog extends Model
{

    protected $table = 'payment_request_log';
    protected $primaryKey = 'payment_id';
    protected $allowedFields = [
        'order_id',
        'user_id',
        'username',
        'date_time',
        'total_amount',
        'prod_id',
        'table_name',
        'quantity',
        'prod_price',
        'sub_total',
        'size',
        'mrp',
        'offer_type',
        'offer_details',
        'offer_price'

    ];
}