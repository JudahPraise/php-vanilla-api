<?php

namespace App\Controllers;

use App\Services\UserService;

class UserController
{
    protected $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function getAllUsers()
    {
        $users = $this->userService->getAllUsers();

        header('Content-Type: application/json');
        echo json_encode($users);
    }

    public function storeNewUser()
    {
        $rawBody = file_get_contents('php://input');

        $requestData = json_decode($rawBody, true);

        if (!$requestData) {
            http_response_code(400); // Bad Request
            echo json_encode(['error' => 'Invalid JSON format']);
            return;
        }

        $this->userService->createUser($requestData);
    }

    public function getUserById($params)
    {
        $userId = $params['id'];

        $user = $this->userService->getUserById($userId);

        if (!$user) {
            http_response_code(404); // Not Found
            echo json_encode(['error' => 'User not found']);
            return;
        }

        echo json_encode(['user' => $user]);
    }

    public function updateUser($params)
    {
        $userId = $params['id'];

        $rawBody = file_get_contents('php://input');

        $requestData = json_decode($rawBody, true);

        if (!$requestData) {
            http_response_code(400); // Bad Request
            echo json_encode(['error' => 'Invalid JSON format']);
            return;
        }

        $this->userService->updateUser($userId, $requestData);

    }

    public function deleteUserById($params)
    {
        $userId = $params['id'];

        $user = $this->userService->deleteUser($userId);

        if (!$user) {
            http_response_code(404); // Not Found
            echo json_encode(['error' => 'User not found']);
            return;
        }

        echo json_encode(['user' => $user]);
    }
}
