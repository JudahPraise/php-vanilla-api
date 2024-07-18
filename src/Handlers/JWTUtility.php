<?php

namespace App\Handlers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTUtility
{
    protected $secretKey;

    public function __construct()
    {
        $config = require_once __DIR__ . '/../../config/auth.php';
        $jwtConfig = $config['jwt'];
        $this->secretKey = $jwtConfig['secret_key'];
    }

    public function generateToken($payload)
    {
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600; // jwt valid for 1 hour
        $payload['iat'] = $issuedAt;
        $payload['exp'] = $expirationTime;

        return JWT::encode($payload, $this->secretKey, 'HS256');
    }

    public function validateToken($token)
    {
        try {
            return JWT::decode($token, new Key($this->secretKey, 'HS256'));
        } catch (\Exception $e) {
            return false;
        }
    }
}
