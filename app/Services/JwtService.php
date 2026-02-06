<?php
namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class JwtService
{
    private $secretKey;

    public function __construct()
    {
        $this->secretKey = getenv('JWT_SECRET');
    }

    // Generate token for guests/logged-in users
    public function generateToken(string $userId, string $role = 'guest', int $expiryDays = 7): string
    {
        $payload = [
            'sub' => $userId,
            'role' => $role,
            'iat' => time(),
            'exp' => time() + ($expiryDays * 86400)
        ];
        return JWT::encode($payload, $this->secretKey, 'HS256');
    }

    // Validate token and return payload
    public function validateToken(string $token): ?object
    {
        try {
            return JWT::decode($token, new Key($this->secretKey, 'HS256'));
        } catch (Exception $e) {
            return null; // Invalid/expired token
        }
    }
}