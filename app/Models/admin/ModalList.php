<?php
namespace App\Models\admin;

use CodeIgniter\Model;

class ModalList extends Model
{
    protected $table = 'tbl_modal_master';
    protected $primaryKey = 'modal_id';
    protected $allowedFields = ['brand_id', 'modal_name','modal_img'];
}