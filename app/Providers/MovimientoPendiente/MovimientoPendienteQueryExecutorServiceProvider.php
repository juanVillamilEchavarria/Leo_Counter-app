<?php

namespace App\Providers\MovimientoPendiente;

use App\Application\MovimientoPendiente\Commands\Handlers\ProcessFinancialTasksForMovimientoPendienteHandler;
use App\Application\MovimientoPendiente\Contracts\Queries\Executors\GetMovimientoPendienteRecordsCountQueryExecutorContract;
use App\Application\MovimientoPendiente\Contracts\Queries\Executors\MovimientoPendienteQueryExecutorContract;
use App\Application\MovimientoPendiente\Queries\Handlers\GetMovimientoPendienteRecordsCountHandler;
use App\Application\MovimientoPendiente\Queries\Handlers\ListAllMovimientoPendienteHandler;
use App\Application\MovimientoPendiente\Queries\ListAllMovimientoPendienteDueForProcessingQuery;
use App\Infrastructure\MovimientoPendiente\Queries\Executors\Eloquent\EloquentGetMovimientoPendienteRecordsCountExecutor;
use App\Infrastructure\MovimientoPendiente\Queries\Executors\Eloquent\EloquentListAllMovimientoPendienteDueForProcessingQueryExecutor;
use App\Infrastructure\MovimientoPendiente\Queries\Executors\Eloquent\EloquentListAllMovimientoPendienteWithDetailsExecutor;
use App\Domains\MovimientoPendiente\Contracts\GetAllAccountsBalanceForMovimientosPendientesContract;
use App\Infrastructure\MovimientoPendiente\Queries\Executors\Eloquent\EloquentGetAllAccountsBalanceForMovimientosPendientesQueryExecutor;
use Illuminate\Support\ServiceProvider;


/**
 * Query executor provider del modulo MovimientoPendiente.
 * Declara las implementaciones concretas que deben recibir los handlers de lectura
 * usando bindings contextuales de Laravel para cada handler especifico.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Providers\MovimientoPendiente
 * @since 1.0.0
 * @version 1.0.0
 */
final class MovimientoPendienteQueryExecutorServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->when(ListAllMovimientoPendienteHandler::class)
            ->needs(MovimientoPendienteQueryExecutorContract::class)
            ->give(EloquentListAllMovimientoPendienteWithDetailsExecutor::class);

        $this->app->when(GetMovimientoPendienteRecordsCountHandler::class)
            ->needs(GetMovimientoPendienteRecordsCountQueryExecutorContract::class)
            ->give(EloquentGetMovimientoPendienteRecordsCountExecutor::class);
        $this->app->when(ListAllMovimientoPendienteDueForProcessingQuery::class)
            ->needs(MovimientoPendienteQueryExecutorContract::class)
            ->give( EloquentListAllMovimientoPendienteDueForProcessingQueryExecutor::class);

        $this->app->singleton(GetAllAccountsBalanceForMovimientosPendientesContract::class, EloquentGetAllAccountsBalanceForMovimientosPendientesQueryExecutor::class);
    }

    public function boot(): void
    {
        //
    }
}
