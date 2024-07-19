<?php

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

return [
    'jwt' => [
        'secret_key' => $_ENV['JWT_SECRET'],
    ],
    'auth_token' => [
        'send_to_cookie' => true,
        'expires' => '60',
        'secure' => true,
        'httponly' => true,
        'samesite' => 'Strict',
    ],
];
