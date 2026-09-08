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

use App\Application\MovimientoPendiente\Contracts\Queries\Executors\GetMovimientoPendienteRecordsCountQueryExecutorContract;
use App\Application\MovimientoPendiente\Contracts\Queries\Executors\MovimientoPendienteForShowQueryExecutorContract;
use App\Application\MovimientoPendiente\Contracts\Queries\Executors\MovimientoPendienteQueryExecutorContract;
use App\Application\MovimientoPendiente\Queries\Handlers\GetMovimientoPendienteRecordsCountHandler;
use App\Application\MovimientoPendiente\Queries\Handlers\ListAllMovimientoPendienteDueForProcessingHandler;
use App\Application\MovimientoPendiente\Queries\Handlers\ListAllMovimientoPendienteHandler;
use App\Domains\MovimientoPendiente\Contracts\GetAllAccountsBalanceForMovimientosPendientesContract;
use App\Infrastructure\MovimientoPendiente\Queries\Executors\Eloquent\EloquentGetAllAccountsBalanceForMovimientosPendientesQueryExecutor;
use App\Infrastructure\MovimientoPendiente\Queries\Executors\Eloquent\EloquentGetMovimientoPendienteRecordsCountExecutor;
use App\Infrastructure\MovimientoPendiente\Queries\Executors\Eloquent\EloquentListAllMovimientoPendienteDueForProcessingQueryExecutor;
use App\Infrastructure\MovimientoPendiente\Queries\Executors\Eloquent\EloquentListAllMovimientoPendienteWithDetailsExecutor;
use App\Infrastructure\MovimientoPendiente\Queries\Executors\Eloquent\EloquentMovimientoPendienteForShowQueryExecutor;
use App\Infrastructure\MovimientoPendiente\Queries\Strategies\EloquentMovimientoPendienteExportQueryStrategy;
use Illuminate\Support\ServiceProvider;

/**
 * Query executor provider del modulo MovimientoPendiente.
 * Declara las implementaciones concretas que deben recibir los handlers de lectura
 * usando bindings contextuales de Laravel para cada handler especifico.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.0.0
 *
 * @version 1.0.0
 */
final class MovimientoPendienteQueryExecutorServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->tag([
            EloquentMovimientoPendienteExportQueryStrategy::class,
        ], 'export.query.strategies');

        $this->app->when(ListAllMovimientoPendienteHandler::class)
            ->needs(MovimientoPendienteQueryExecutorContract::class)
            ->give(EloquentListAllMovimientoPendienteWithDetailsExecutor::class);

        $this->app->when(GetMovimientoPendienteRecordsCountHandler::class)
            ->needs(GetMovimientoPendienteRecordsCountQueryExecutorContract::class)
            ->give(EloquentGetMovimientoPendienteRecordsCountExecutor::class);
        $this->app->when(ListAllMovimientoPendienteDueForProcessingHandler::class)
            ->needs(MovimientoPendienteQueryExecutorContract::class)
            ->give(EloquentListAllMovimientoPendienteDueForProcessingQueryExecutor::class);

        $this->app->singleton(GetAllAccountsBalanceForMovimientosPendientesContract::class, EloquentGetAllAccountsBalanceForMovimientosPendientesQueryExecutor::class);
        $this->app->singleton(MovimientoPendienteForShowQueryExecutorContract::class, EloquentMovimientoPendienteForShowQueryExecutor::class);
    }

    public function boot(): void
    {
        //
    }
}
