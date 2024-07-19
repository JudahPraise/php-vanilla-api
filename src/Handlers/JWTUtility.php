<?php

namespace App\Handlers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTUtility
{
    protected $secretKey;
    protected $authTokenConfig;

    public function __construct()
    {
        $config = require_once __DIR__ . '/../../config/auth.php';
        $jwtConfig = $config['jwt'];
        $authTokenConfig = $config['auth_token'];
        $this->secretKey = $jwtConfig['secret_key'];
        $this->authTokenConfig = $authTokenConfig;
    }

    public function generateToken($payload)
    {
        $issuedAt = time();
        $expirationTime = $issuedAt + ($this->authTokenConfig['expires'] * 60); // jwt valid for 1 hour
        $payload['iat'] = $issuedAt;
        $payload['exp'] = $expirationTime;

        $token = JWT::encode($payload, $this->secretKey, 'HS256');

        if ($this->authTokenConfig['send_to_cookie']) {
            // Set the token in a cookie based on the config
            setcookie("auth_token", $token, [
                'expires' => $expirationTime, // Convert minutes to seconds
                'path' => '/',
                'domain' => '', // Set your domain if needed
                'secure' => $this->authTokenConfig['secure'],
                'httponly' => $this->authTokenConfig['httponly'],
                'samesite' => $this->authTokenConfig['samesite'],
            ]);

            return json_encode(['message' => 'Login successful']);
        } else {
            // Return the token directly in the response
            return json_encode(['token' => $token]);
        }

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
