<?php

namespace App\Providers\ArchivoMovimiento;

use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;
use App\Application\ArchivoMovimiento\Commands\StoreArchivoMovimientoCommand;
use App\Application\ArchivoMovimiento\Commands\Handlers\StoreArchivoMovimientoHandler;

class ArchivoMovimientoBusProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Bus::map([
            StoreArchivoMovimientoCommand::class => StoreArchivoMovimientoHandler::class,
        ]);
    }
}
