<?php

namespace App\Providers\Movimiento;

use App\Application\Movimiento\Commands\Handlers\UpdateMovimientoHandler;
use App\Application\Movimiento\Commands\UpdateMovimientoCommand;
use App\Application\Movimiento\Commands\DestroyMovimientoCommand;
use App\Application\Movimiento\Commands\Handlers\DestroyMovimientoHandler;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;
use App\Application\Movimiento\Commands\StoreMovimientoCommand;
use App\Application\Movimiento\Commands\Handlers\StoreMovimientoHandler;
use App\Shared\Infrastructure\Framework\Laravel\Middlewares\LaravelTransactionMiddleware;

class MovimientoBusProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Bus::map(
            [
                StoreMovimientoCommand::class => StoreMovimientoHandler::class,
                UpdateMovimientoCommand::class => UpdateMovimientoHandler::class,
                DestroyMovimientoCommand::class => DestroyMovimientoHandler::class,
            ]
        );
        Bus::pipeThrough([
            LaravelTransactionMiddleware::class,
        ]);
    }
}
