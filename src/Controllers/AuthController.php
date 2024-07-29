<?php

namespace App\Controllers;

use App\Handlers\JWTUtility;
use App\Models\User;

class AuthController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function login()
    {
        $rawBody = file_get_contents('php://input');
        $requestData = json_decode($rawBody, true);

        if (!$requestData || !isset($requestData['username']) || !isset($requestData['password'])) {
            http_response_code(400); // Bad Request
            echo json_encode(['error' => 'Invalid login details']);
            return;
        }

        $user = $this->userModel->findByUsername($requestData['username']);

        if ($user && password_verify($requestData['password'], $user['password'])) {
            $jwtUtility = new JWTUtility();
            $token = $jwtUtility->generateToken(['username' => $user['username']]);
        } else {
            http_response_code(401); // Unauthorized
            echo json_encode(['error' => 'Invalid credentials']);
        }

    }

    public function validate()
    {
        $jwtUtility = new JWTUtility();

        // Retrieve the token from the cookie
        $token = $_COOKIE['auth_token'] ?? null;

        // Validate the token and return response
        if (isset($token)) {
            if ($token && $payload = $jwtUtility->validateToken($token)) {
                http_response_code(200);
            } else {
                http_response_code(401); // Unauthorized
                echo json_encode(['error' => 'Invalid token']);
            }
        } else {
            http_response_code(201);
        }

    }

    public function logout()
    {

        $expirationTime = time() + (2 * 60);
        setcookie("auth_token", "", [
            'expires' => $expirationTime, // Convert minutes to seconds
            'path' => '/',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'None',
        ]);

        http_response_code(200);
        echo json_encode(['message' => 'Logged out successfully!']);

    }
}
