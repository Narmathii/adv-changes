<?php

namespace App\Libraries;

use \Mailjet\Resources;
use App\Config\Mailjet;

class MailjetService
{
    protected $apiKey;
    protected $secretKey;
    protected $client;

    public function __construct()
    {
        $config = new Mailjet();
        $this->apiKey = $config->apiKey;
        $this->secretKey = $config->secretKey;

        // Initialize the Mailjet client
        $this->client = new \Mailjet\Client($this->apiKey, $this->secretKey, true, ['version' => 'v3.1']);
    }

    public function sendEmail($toEmail, $toName, $subject, $body)
    {
        $message = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => 'abhishek@adventureshoppe.com',
                        'Name' => 'Adventure Shoppe'
                    ],
                    'To' => [
                        [
                            'Email' => $toEmail,
                            'Name' => $toName
                        ]
                    ],
                    'Subject' => $subject,
                    'TextPart' => $body,
                    'HTMLPart' => $body
                ]
            ]
        ];

        $response = $this->client->post(Resources::$Email, ['body' => $message]);

        if ($response->success()) {
            return true;
        }

        return false;
    }
}
