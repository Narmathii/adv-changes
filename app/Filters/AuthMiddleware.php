<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\Key;
use Firebase\JWT\JWT;

class AuthMiddleware implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $accessToken = null;

        $authHeader = $request->getHeaderLine('Authorization');
        if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $accessToken = $matches[1];
        }

        // If no token in header, check the URL parameter (?token=...)
        if (!$accessToken) {
            $accessToken = $request->getGet('token');
        }


        if (!$accessToken) {
            return $this->unauthorizedResponse('Token not provided');
        }


        $secretToken = getenv('JWT_SECRET');
        if (!$secretToken) {
            return $this->unauthorizedResponse('JWT secret key is missing.');
        }

        try {

            JWT::decode($accessToken, new Key($secretToken, 'HS256'));

            return true;
        } catch (\Exception $e) {
            return $this->unauthorizedResponse('Invalid token');
        }
    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something after the controller is executed if needed
    }

    private function unauthorizedResponse($message)
    {
        $session = session();
        $session->destroy();
        return \Config\Services::response()
            ->setStatusCode(401)
            ->setJSON(['code' => 401, 'message' => $message]);
    }
}
