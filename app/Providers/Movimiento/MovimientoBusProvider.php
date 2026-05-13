<?php

namespace App\Providers\Movimiento;

use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;
use App\Application\Movimiento\Commands\StoreMovimientoCommand;
use App\Application\Movimiento\Commands\Handlers\StoreMovimientoHandler;

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
        Bus::map([StoreMovimientoCommand::class => StoreMovimientoHandler::class]);
    }
}
