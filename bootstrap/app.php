<?php

use App\Http\Middleware\AuthenticateOnceWithBasicAuth;
use App\Http\Middleware\LimitRequests;
use App\Http\Middleware\ResponseWithJson;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->api(prepend: [
            ResponseWithJson::class,
            LimitRequests::class,
        ]);

        $middleware->alias([
            'auth.basic.once' => AuthenticateOnceWithBasicAuth::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->shouldRenderJsonWhen(function (Request $request, Throwable $e) {
            if ($request->is('api/*')) {
                return true;
            }

            return $request->expectsJson();
        });

        $exceptions->render(function (NotFoundHttpException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], $e->getCode());
        });
    })->create();
