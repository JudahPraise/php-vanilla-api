<?php
namespace App\Models;

use App\Handlers\Database;
use PDO;

class User extends Database
{

    public function getAllUsers()
    {
        $stmt = $this->db->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findUserById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByUsername($username)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createUser($data)
    {
        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);

        $stmt = $this->db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->execute();
        return $this->db->lastInsertId();
    }

    public function updateUser($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE users SET username = :username, password = :password WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':password', $data['password']);
        $stmt->execute();
        return ['affected_rows' => $stmt->rowCount()];
    }

    public function deleteUser($id)
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return ['affected_rows' => $stmt->rowCount()];
    }
}
