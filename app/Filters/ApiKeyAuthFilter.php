<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\Services;

class ApiKeyAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $apiKeyHeader = $request->getHeaderLine('X-API-KEY');


        // Your predefined API key
        $validApiKey = env('X-API-KEY');

        if (empty($apiKeyHeader)) {
            return Services::response()
                ->setStatusCode(401)
                ->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        if ($apiKeyHeader !== $validApiKey) {
            return Services::response()
                ->setStatusCode(401)
                ->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        // Proceed if API key is valid
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nothing to do here
    }
}
