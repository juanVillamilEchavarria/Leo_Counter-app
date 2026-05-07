<?php

namespace App\Providers\Presupuesto;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Bus;
use App\Application\Presupuesto\Commands\StorePresupuestoCommand;
use App\Application\Presupuesto\Commands\UpdatePresupuestoCommand;
use App\Application\Presupuesto\Commands\DestroyPresupuestoCommand;
use App\Application\Presupuesto\Commands\DuplicatePresupuestoCommand;
use App\Application\Presupuesto\Commands\Handlers\StorePresupuestoHandler;
use App\Application\Presupuesto\Commands\Handlers\UpdatePresupuestoHandler;
use App\Application\Presupuesto\Commands\Handlers\DestroyPresupuestoHandler;
use App\Application\Presupuesto\Commands\Handlers\DuplicatePresupuestoHandler;

class PresupuestoBusProvider extends ServiceProvider
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
         Bus::map([
            StorePresupuestoCommand::class     => StorePresupuestoHandler::class,
            UpdatePresupuestoCommand::class    => UpdatePresupuestoHandler::class,
            DestroyPresupuestoCommand::class   => DestroyPresupuestoHandler::class,
            DuplicatePresupuestoCommand::class => DuplicatePresupuestoHandler::class,
        ]);
    }
}
