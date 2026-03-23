<?php

use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Http\Middleware\TrustProxies;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => IsAdmin::class,
        ]);

        $middleware->api(prepend: [
            TrustProxies::class,
        ]);

        $middleware->web(append: [
            VerifyCsrfToken::class,
            AddQueuedCookiesToResponse::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
