<?php

use App\Handlers\Router;

$router = new Router();

$router->addRoute('GET', '/users', 'App\\Controllers\\UserController@getAllUsers');
$router->addRoute('POST', '/users', 'App\\Controllers\\UserController@storeNewUser');
$router->addRoute('GET', '/users/{id}', 'App\\Controllers\\UserController@getUserById');
$router->addRoute('PUT', '/users/{id}', 'App\\Controllers\\UserController@updateUser');
$router->addRoute('DELETE', '/users/{id}', 'App\\Controllers\\UserController@deleteUserById');

$router->addRoute('POST', '/login', 'App\\Controllers\\AuthController@login');

return $router;
