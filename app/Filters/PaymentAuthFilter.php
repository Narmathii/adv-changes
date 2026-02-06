<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\Key;
use Firebase\JWT\JWT;

class PaymentAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $accessToken = $session->get('jwt');


        if (!$accessToken) {
            return $this->unauthorizedResponse('You must be logged in to access the payment page.');
        }

        $secretToken = getenv('JWT_SECRET');
        if (!$secretToken) {
            return $this->unauthorizedResponse('JWT secret key is missing.');
        }

        try {
            $decoded = JWT::decode($accessToken, new Key($secretToken, 'HS256'));
            return true;
        } catch (\Exception $e) {
            return $this->unauthorizedResponse('Invalid token');
        }
    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }

    private function unauthorizedResponse($message)
    {
        $session = session();
        $session->destroy();
        return redirect()->to('login');
    }
}
