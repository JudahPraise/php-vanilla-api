<?php

namespace App\Middlewares;

use App\Handlers\JWTUtility;
use App\Middlewares\MiddlewareInterface;

class AuthMiddleware implements MiddlewareInterface
{
    public function handle($request, $next)
    {
        $exemptRoutes = ['/login'];

        $path = parse_url($request['REQUEST_URI'], PHP_URL_PATH);

        if (in_array($path, $exemptRoutes)) {
            return $next($request);
        }

        $headers = getallheaders();
        if (!isset($headers['Authorization'])) {
            http_response_code(401); // Unauthorized
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }

        $jwt = str_replace('Bearer ', '', $headers['Authorization']);
        $jwtUtility = new JWTUtility();

        $decoded = $jwtUtility->validateToken($jwt);
        if (!$decoded) {
            http_response_code(401); // Unauthorized
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }

        return $next($request);
    }
}
