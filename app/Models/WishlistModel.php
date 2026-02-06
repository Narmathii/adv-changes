<?php

namespace App\Models;

use CodeIgniter\Model;

class WishlistModel extends Model
{

    protected $table = 'tbl_wishlist';
    protected $primaryKey = 'wishlist_id	';
    protected $allowedFields = [
        'prod_id',
        'tbl_name',
        'user_id',
        'size_stock',
        'size'

    ];
}