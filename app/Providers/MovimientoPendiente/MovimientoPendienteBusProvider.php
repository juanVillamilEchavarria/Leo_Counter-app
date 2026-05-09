<?php

namespace App\Providers\MovimientoPendiente;

use App\Application\MovimientoPendiente\Commands\DestroyMovimientoPendienteCommand;
use App\Application\MovimientoPendiente\Commands\Handlers\DestroyMovimientoPendienteHandler;
use App\Application\MovimientoPendiente\Commands\Handlers\StoreMovimientoPendienteHandler;
use App\Application\MovimientoPendiente\Commands\Handlers\UpdateMovimientoPendienteHandler;
use App\Application\MovimientoPendiente\Commands\StoreMovimientoPendienteCommand;
use App\Application\MovimientoPendiente\Commands\UpdateMovimientoPendienteCommand;
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
        ]);
    }
}
