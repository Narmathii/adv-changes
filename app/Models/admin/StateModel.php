<?php

namespace App\Models\admin;

use CodeIgniter\Model;

class StateModel extends Model
{

    protected $table = 'tbl_state';
    protected $primaryKey = 'state_id';
    protected $allowedFields = [
        'state_title'

    ];

}