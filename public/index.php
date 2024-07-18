<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../routes/api.php';

use App\Handlers\Middleware;
use App\Middlewares\CorsMiddleware;

// Create a middleware handler
$middlewareHandler = new Middleware();

// Add middleware
$middlewareHandler->addMiddleware(new CorsMiddleware());

$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Main handler to handle the request
$mainHandler = function ($request) use ($router, $method, $path) {
    $router->handleRequest($method, $path);
};

// Process the request through middleware
$middlewareHandler->handle($_SERVER, $mainHandler);
