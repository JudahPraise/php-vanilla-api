<?php

namespace App\Handlers;

class Router
{
    protected $routes = [];

    public function addRoute($method, $path, $handler)
    {
        $this->routes[$method][$path] = $handler;
    }

    public function handleRequest($method, $uri)
    {
        $uri = parse_url($uri, PHP_URL_PATH);

        foreach ($this->routes[$method] as $route => $handler) {
            // Replace {id} and {type} with wildcards to match any ID and type
            $routeRegex = preg_replace('/\{(\w+)\}/', '(\w+)', $route);

            // Check if the current route matches the requested URI
            if (preg_match("#^$routeRegex$#", $uri, $matches)) {
                // Extract parameters from the URI
                $params = [];
                preg_match_all('/\{(\w+)\}/', $route, $paramNames);

                foreach ($paramNames[1] as $index => $paramName) {
                    $params[$paramName] = $matches[$index + 1];
                }

                // Split the handler into class and method
                list($class, $method) = explode('@', $handler);

                // Create instance of the controller class
                $controller = new $class();

                // Call the method with parameters
                $controller->$method($params);

                return;
            }
        }

        // Handle 404 Not Found
        http_response_code(404);
        echo json_encode(['error' => 'Route not found']);
    }
}
