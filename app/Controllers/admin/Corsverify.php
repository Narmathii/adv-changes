<?php

namespace App\Controllers\admin;

use CodeIgniter\RESTful\ResourceController;

class Dummy extends ResourceController
{
    public function options()
    {
        return $this->response->setHeader('Access-Control-Allow-Origin', '*')
                              ->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS')
                              ->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization')
                              ->setStatusCode(204);
    }
}
