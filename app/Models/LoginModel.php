<?php
namespace App\Models;

use CodeIgniter\Model;

class LoginModel extends Model
{
    protected $table = 'tbl_users';
    protected $primaryKey = 'user_id';
    protected $allowedFields = [
        'username',
        'number',
        'email',
        'password',
        'otp',
        'status'
    ];
}