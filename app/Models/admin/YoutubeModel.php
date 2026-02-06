<?php
namespace App\Models\admin;

use CodeIgniter\Model;

class YoutubeModel extends Model
{
    protected $table = 'tbl_youtube';
    protected $primaryKey = 'ytube_id';
    protected $allowedFields = ['ytube_link', 'ytube_img'];
}