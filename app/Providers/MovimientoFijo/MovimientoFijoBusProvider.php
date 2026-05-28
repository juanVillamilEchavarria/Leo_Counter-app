<?php

namespace App\Providers\MovimientoFijo;

use App\Application\MovimientoFijo\Commands\DestroyMovimientoFijoCommand;
use App\Application\MovimientoFijo\Commands\Handlers\DestroyMovimientoFijoHandler;
use App\Application\MovimientoFijo\Commands\Handlers\StoreMovimientoFijoHandler;
use App\Application\MovimientoFijo\Commands\Handlers\ToggleMovimientoFijoHandler;
use App\Application\MovimientoFijo\Commands\Handlers\UpdateMovimientoFijoHandler;
use App\Application\MovimientoFijo\Commands\StoreMovimientoFijoCommand;
use App\Application\MovimientoFijo\Commands\ToggleMovimientoFijoCommand;
use App\Application\MovimientoFijo\Commands\UpdateMovimientoFijoCommand;
use App\Application\MovimientoFijo\Commands\ProcessFinancialTaskForMovimientoFijoCommand;
use App\Application\MovimientoFijo\Commands\Handlers\ProcessFinancialTasksForMovimientoFijoHandler;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;

/**
 * Bus provider del modulo MovimientoFijo.
 * Registra el mapeo explicito entre comandos de aplicacion y sus handlers.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Providers\MovimientoFijo
 * @since 1.0.0
 * @version 1.0.0
 */
final class MovimientoFijoBusProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Bus::map([
            StoreMovimientoFijoCommand::class => StoreMovimientoFijoHandler::class,
            UpdateMovimientoFijoCommand::class => UpdateMovimientoFijoHandler::class,
            DestroyMovimientoFijoCommand::class => DestroyMovimientoFijoHandler::class,
            ToggleMovimientoFijoCommand::class => ToggleMovimientoFijoHandler::class,
            ProcessFinancialTaskForMovimientoFijoCommand::class => ProcessFinancialTasksForMovimientoFijoHandler::class,
        ]);
    }
}
