<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductTallyMappingModel extends Model
{

    protected $table = 'tally_details';
    protected $primaryKey = 'tally_id';
    protected $allowedFields = [
        'order_id',
        'product_name',
        'customer_name',
        'prod_id',
        'tbl_name',
        'product_price',
        'courier_charge',
        'total_amount',
        'payment_status',
        'color',
        'hex_code',
        'size',
        'old_quantity',
        'new_quantity',
        'shipping_qty',
        'menu',
        'submenu',
        'tally_sync_status',
        'order_no',
        'actual_price',
        'offer_price',
        'offer_type',
        'offer_details'
    ];

}