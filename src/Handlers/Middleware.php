<?php

namespace App\Handlers;

class Middleware
{
    protected $middlewares = [];

    public function addMiddleware($middleware)
    {
        $this->middlewares[] = $middleware;
    }

    public function handle($request, $mainHandler)
    {
        $next = $mainHandler;

        // Loop through middleware in reverse order to chain them
        foreach (array_reverse($this->middlewares) as $middleware) {
            $next = function ($request) use ($middleware, $next) {
                return $middleware->handle($request, $next);
            };
        }

        return $next($request);
    }
}
