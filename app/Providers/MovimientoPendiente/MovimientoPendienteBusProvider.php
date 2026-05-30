<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Providers\MovimientoPendiente;

use App\Application\MovimientoPendiente\Commands\DestroyMovimientoPendienteCommand;
use App\Application\MovimientoPendiente\Commands\Handlers\DestroyMovimientoPendienteHandler;
use App\Application\MovimientoPendiente\Commands\Handlers\StoreMovimientoPendienteHandler;
use App\Application\MovimientoPendiente\Commands\Handlers\UpdateMovimientoPendienteHandler;
use App\Application\MovimientoPendiente\Commands\MarkAsDoneMovimientoPendienteCommand;
use App\Application\MovimientoPendiente\Commands\StoreMovimientoPendienteCommand;
use App\Application\MovimientoPendiente\Commands\UpdateMovimientoPendienteCommand;
use App\Application\MovimientoPendiente\Commands\Handlers\MarkAsDoneMovimientoPendienteHandler;
use App\Application\MovimientoPendiente\Commands\RegisterMovimientoPendienteFromMovimientoFijoCommand;
use App\Application\MovimientoPendiente\Commands\MarkMovimientoPendienteAsExpiredCommand;
use App\Application\MovimientoPendiente\Commands\ProcessFinancialTasksForMovimientoPendienteCommand;
use App\Application\MovimientoPendiente\Commands\Handlers\RegisterMovimientoPendienteFromMovimientoFijoHandler;
use App\Application\MovimientoPendiente\Commands\Handlers\MarkMovimientoPendienteAsExpiredHandler;
use App\Application\MovimientoPendiente\Commands\Handlers\ProcessFinancialTasksForMovimientoPendienteHandler;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;

/**
 * Bus provider del modulo MovimientoPendiente.
 * Registra el mapeo explicito entre comandos de aplicacion y sus handlers correspondientes.
 *
 * No incluye el comando MarkAsDoneMovimientoPendienteCommand porque esa funcionalidad
 * sera abordada en una fase posterior del refactor.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Providers\MovimientoPendiente
 * @since 1.0.0
 * @version 1.0.0
 */
final class MovimientoPendienteBusProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Bus::map([
            StoreMovimientoPendienteCommand::class => StoreMovimientoPendienteHandler::class,
            UpdateMovimientoPendienteCommand::class => UpdateMovimientoPendienteHandler::class,
            DestroyMovimientoPendienteCommand::class => DestroyMovimientoPendienteHandler::class,
            MarkAsDoneMovimientoPendienteCommand::class=> MarkAsDoneMovimientoPendienteHandler::class,

            // Automatizaciones diarias: comandos relacionados
            RegisterMovimientoPendienteFromMovimientoFijoCommand::class => RegisterMovimientoPendienteFromMovimientoFijoHandler::class,
            MarkMovimientoPendienteAsExpiredCommand::class => MarkMovimientoPendienteAsExpiredHandler::class,
            ProcessFinancialTasksForMovimientoPendienteCommand::class => ProcessFinancialTasksForMovimientoPendienteHandler::class,
        ]);
    }
}
