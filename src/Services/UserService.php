<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    protected $model;

    public function __construct()
    {
        $this->model = new User();
    }

    public function getAllUsers()
    {
        return $this->model->getAllUsers();
    }

    public function createUser($payload)
    {
        return $this->model->createUser($payload);
    }

    public function getUserById($id)
    {
        return $this->model->findUserById($id);
    }

    public function updateUser($id, $payload)
    {
        return $this->model->updateUser($id, $payload);
    }

    public function deleteUser($id)
    {
        return $this->model->deleteUser($id);
    }
}
