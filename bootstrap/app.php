<?php

use App\Exceptions\Handler;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        // 1. Reportable Exceptions (Reporting to logging services)
        $exceptions->report(function (Throwable $e) {
            // Add custom reporting logic here if needed, or leave blank.
        });

        // 2. Renderable Exceptions (Sending a response to the user)
        // This replaces the logic that was in Handler::register()
        $exceptions->render(function (Throwable $e, Request $request) {

            // Check if the request is for the API, using the improved condition
            if ($request->is('api/*') || $request->expectsJson()) {

                $handler = app(Handler::class);

                return $handler->handleApiException($request, $e);
            }

        });

    })

    ->create();
