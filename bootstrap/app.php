<?php

use App\Http\Middleware\HandleInertiaRequests;
use App\Utils\InertiaParserException;
use Carbon\CarbonInterval;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\CaptureInertiaPage::class,
            HandleInertiaRequests::class,

        ]);
        $middleware->api(prepend: [
            EnsureFrontendRequestsAreStateful::class,
        ]);
        $middleware->alias([
            'rate.limit' => \App\Shared\Infrastructure\Framework\Laravel\Middlewares\RateLimitMiddleware::class,
        ]);
        $middleware->validateCsrfTokens(except: [
            // 'api/*',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\App\Shared\Domain\Exceptions\ClientFacingException $exception, \Illuminate\Http\Request $request) {
            $fallback = response()->json(['error' => $exception->getMessage()], 500);

            return InertiaParserException::parse($exception, $request, $fallback);

        });
    })->create();
