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

            echo $token;
        } else {
            http_response_code(401); // Unauthorized
            echo json_encode(['error' => 'Invalid credentials']);
        }

    }
}
