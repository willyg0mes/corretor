<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'corretor' => \App\Http\Middleware\EnsureUserIsCorretor::class,
            'admin' => \App\Http\Middleware\EnsureUserIsAdmin::class,
            'large-upload' => \App\Http\Middleware\HandleLargeUploads::class,
        ]);

        // Apply large upload middleware to web routes
        $middleware->web(append: [
            \App\Http\Middleware\HandleLargeUploads::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
