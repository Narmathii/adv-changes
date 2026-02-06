<?php
namespace App\Services;

class EncryptionService
{
    public static function generateKey()
    {
        return \CodeIgniter\Encryption\Encryption::createKey();
    }
}