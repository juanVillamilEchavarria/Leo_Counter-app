<?php

use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Inertia\Inertia;
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
            HandleInertiaRequests::class



        ]);
        $middleware->api(prepend: [
            EnsureFrontendRequestsAreStateful::class,
        ]);
        $middleware->validateCsrfTokens(except: [
            // 'api/*',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\App\Shared\Domain\Exceptions\ClientFacingException $exception, \Illuminate\Http\Request $request) {
            if ($request->inertia()) {
                $pageData = session()->get('_inertia_page', []);
                $component = $pageData['component'] ?? 'Error';
                $props = $pageData['props'] ?? [];

                // Añadimos el error a las props compartidas
                Inertia::share('flash', [
                    'success' => null,
                    'error' => $exception->getMessage(),
                ]);

                return Inertia::render($component, $props);
            }

            // Si no es Inertia, devolvemos un error genérico
            return response()->json(['error' => $exception->getMessage()], 500);
        });
    })->create();
