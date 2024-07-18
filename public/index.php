<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../routes/api.php';

$config = require_once __DIR__ . '/../config/cors.php';
$corsConfig = $config['cors'];

header("Access-Control-Allow-Origin: " . implode(', ', $corsConfig['origins']));
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: " . implode(', ', $corsConfig['methods']));
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$router->handleRequest($method, $path);
