<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{

    protected $table = 'tbl_transaction';
    protected $primaryKey = 'trans_id';
    protected $allowedFields = [
        'user_id',
        'transaction',
    ];
}