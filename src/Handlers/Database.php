<?php

namespace App\Handlers;

use PDO;

class Database
{
    protected $db;

    public function __construct()
    {
        // Include configuration file
        $config = require_once __DIR__ . '/../../config/app.php';
        $dbConfig = $config['db'];

        $dsn = "mysql:host={$dbConfig['host']};dbname={$dbConfig['database']}";
        $username = $dbConfig['username'];
        $password = $dbConfig['password'];

        try {
            $this->db = new PDO($dsn, $username, $password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Handle PDO connection error
            die('Connection failed: ' . $e->getMessage());
        }
    }
}
