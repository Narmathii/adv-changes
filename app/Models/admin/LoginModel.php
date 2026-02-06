<?php
namespace App\Models\admin;
use CodeIgniter\Model;

class LoginModel extends Model{
    protected $table = 'tbl_admin';

     protected $primaryKey = 'tbl_admin';
    protected $allowedFields = ['username', 'password','user_type'];
}