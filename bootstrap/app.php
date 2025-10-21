<?php

use App\Exceptions\ExceptionHandler;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->statefulApi();
        $middleware->alias(['set-locale' => \App\Http\Middleware\SetLocale::class]);
        $middleware->api(['set-locale']);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Instantiate the ExceptionHandler
        $exceptionHandler = new ExceptionHandler();

        $exceptions->render(function (Throwable $e) use ($exceptionHandler) {
            \Illuminate\Support\Facades\Log::error('message', [
                'message' => $e->getMessage(),
            ]);
            // Handle API or JSON-based responses
            if (request()->is('api/*'))
                return $exceptionHandler->handleApiException($e);
            // Handle Web-based (non-API) responses
        });
    })->create();
