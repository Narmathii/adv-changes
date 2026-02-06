<?php

namespace App\Libraries;

use GuzzleHttp\Client;

class TwoFactorApi
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://2factor.in/API/',
        ]);
    }

    public function sendSMS($apiKey, $to, $otp)
    {
        try {
            $response = $this->client->request('GET', 'V1/' . $apiKey . '/SMS/' . 'VERIFY3/' . $to . '/' . urlencode($otp));
            return $response->getBody()->getContents();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
