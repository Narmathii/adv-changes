<?php

namespace App\Models;

use CodeIgniter\Model;

class WebhookPaymentLog extends Model
{

    protected $table = 'webhook_payment_log';
    protected $primaryKey = 'web_id';
    protected $allowedFields = [
        'order_id',
        'user_id',
        'username',
        'razorpay_payment_id',
        'razorpay_order_id',
        'razorpay_signature',
        'date_time',
        'payment_method',
        'total_amount',
        'payment_status',
         'event_log'

    ];
}