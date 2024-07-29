<?php

namespace App\Middlewares;

use App\Middlewares\MiddlewareInterface;

class CorsMiddleware implements MiddlewareInterface
{
    public function handle($request, $next)
    {
        $config = require_once __DIR__ . '/../../config/cors.php';
        $corsConfig = $config['cors'];

        header("Access-Control-Allow-Origin: http://localhost:5173");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT");
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, Accept, Access-Control-Request-Method, Access-Control-Request-Headers, Content-Type, Authorization, X-Requested-With");
        header("Access-Control-Allow-Credentials: true");
        header("Access-Control-Max-Age: 3600");

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(204);
            exit;
        }

        // Call the next middleware or main application logic
        return $next($request);

    }
}
