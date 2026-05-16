<?php

namespace App\Providers\ArchivoMovimiento;

use App\Application\ArchivoMovimiento\Commands\UpdateArchivoMovimientoCommand;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;
use App\Application\ArchivoMovimiento\Commands\StoreArchivoMovimientoCommand;
use App\Application\ArchivoMovimiento\Commands\Handlers\StoreArchivoMovimientoHandler;
use App\Application\ArchivoMovimiento\Commands\Handlers\UpdateArchivoMovimientoHandler;
use App\Application\ArchivoMovimiento\Commands\DestroyArchivoMovimientoCommand;
use App\Application\ArchivoMovimiento\Commands\Handlers\DestroyArchivoMovimientoHandler;
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
            UpdateArchivoMovimientoCommand::class=> UpdateArchivoMovimientoHandler::class,
            DestroyArchivoMovimientoCommand::class=> DestroyArchivoMovimientoHandler::class
        ]);
    }
}
