<?php

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

return [
    'jwt' => [
        'secret_key' => $_ENV['JWT_SECRET'],
    ],
];
