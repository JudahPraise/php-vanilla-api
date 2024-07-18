<?php

namespace App\Middlewares;

use App\Middlewares\MiddlewareInterface;

class CorsMiddleware implements MiddlewareInterface
{
    public function handle($request, $next)
    {
        $config = require_once __DIR__ . '/../../config/cors.php';
        $corsConfig = $config['cors'];

        header("Access-Control-Allow-Origin: " . implode(', ', $corsConfig['origins']));
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: " . implode(', ', $corsConfig['methods']));
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

        $allowedMethods = $corsConfig['methods'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if (!in_array($requestMethod, $allowedMethods)) {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['error' => 'Method not allowed']);
            return;
        }

        // Call the next middleware or main application logic
        return $next($request);

    }
}
