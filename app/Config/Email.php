<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    public $fromEmail = 'narmathi@appteq.in';
    public $fromName = 'Mathi';
    public $recipients = [];
    public $SMTPHost = 'ssl://smtp.gmail.com'; // SMTP server address
    public $SMTPUser = 'narmathi@appteq.in'; // SMTP username
    public $SMTPPass = 'ewmnsvyyahdvmapx'; // SMTP password
    public $SMTPPort = 587; // SMTP port
    public $SMTPCrypto = 'tls'; // 'ssl' or 'tls'
    public $SMTPTimeout = 60; // Timeout in seconds

    public $mailType = 'html'; // Can be 'text' or 'html'
    public $charset = 'UTF-8';
    public $wordWrap = true;
}
