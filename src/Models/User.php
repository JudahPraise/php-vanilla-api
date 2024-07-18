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

    public function getUserById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createUser($data)
    {
        $stmt = $this->db->prepare("INSERT INTO users (name, email) VALUES (:name, :email)");
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->execute();
        return ['id' => $this->db->lastInsertId()];
    }

    public function updateUser($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE users SET name = :name, email = :email WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':email', $data['email']);
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
