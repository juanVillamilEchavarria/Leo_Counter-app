<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Providers\Movimiento;

use App\Application\Movimiento\Commands\DestroyMovimientoCommand;
use App\Application\Movimiento\Commands\Handlers\DestroyMovimientoHandler;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;
use App\Application\Movimiento\Commands\StoreMovimientoCommand;
use App\Application\Movimiento\Commands\Handlers\StoreMovimientoHandler;
use App\Shared\Infrastructure\Framework\Laravel\Middlewares\LaravelTransactionMiddleware;
use App\Application\Movimiento\Commands\RegisterMovimientoFromMovimientoFijoCommand;
use App\Application\Movimiento\Commands\Handlers\RegisterMovimientoFromMovimientoFijoHandler;

/**
 * Bus provider del módulo Movimiento.
 * Registra el mapeo explicito entre comandos de aplicacion y sus handlers correspondientes.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Providers\Movimiento
 * @since 1.0.0
 * @version 1.0.0
 */
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
        Bus::map([
            StoreMovimientoCommand::class   => StoreMovimientoHandler::class,
            DestroyMovimientoCommand::class => DestroyMovimientoHandler::class,
            RegisterMovimientoFromMovimientoFijoCommand::class => RegisterMovimientoFromMovimientoFijoHandler::class,
        ]);
    }
}
