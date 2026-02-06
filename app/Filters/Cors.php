<?php

declare(strict_types=1);

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Cors implements FilterInterface
{
    /**
     * Handles CORS before the request is processed.
     *
     * @param RequestInterface $request
     * @param array|null $arguments
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $response = service('response');

        // Allow requests from both 'www' and non-'www' domains
        $allowedOrigins = [
            'https://adventureshoppe.com',
            'https://www.adventureshoppe.com',
        ];

        // Get the 'Origin' header from the incoming request
        $origin = $request->getHeaderLine('Origin');

        if (in_array($origin, $allowedOrigins)) {
            // Set CORS headers to allow the incoming domain
            $response->setHeader('Access-Control-Allow-Origin', $origin);
        } else {
            // Set a default fallback if the Origin is not allowed
            $response->setHeader('Access-Control-Allow-Origin', 'https://www.adventureshoppe.com');
        }

        // Allow various methods for CORS requests
        $response->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE, PATCH')
            ->setHeader('Access-Control-Allow-Headers', 'X-API-KEY, X-Requested-With, Content-Type, Accept, Authorization')
            ->setHeader('Access-Control-Allow-Credentials', 'true')
            ->setHeader('Access-Control-Max-Age', '3600'); // Cache preflight responses for 1 hour

        // Handle OPTIONS requests for preflight checks
        if ($request->getMethod(true) === 'OPTIONS') {
            return $response->setStatusCode(204)->send();
        }
    }

    /**
     * Handles CORS after the request is processed.
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param array|null $arguments
     * @return void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Additional headers can be added here if needed.
    }
}
