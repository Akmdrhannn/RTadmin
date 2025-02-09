<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middleware = [
        // ...
    ];

    protected $middlewareGroups = [
        // ...
    ];

    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\ApiAuthMiddleware::class,
    ];
}
