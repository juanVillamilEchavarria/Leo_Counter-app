<?php

namespace App\Providers\Movimiento;

use Illuminate\Support\ServiceProvider;
use App\Application\Movimiento\Queries\Handlers\ListAllMovimientoWithDetailsHandler;
use App\Application\Movimiento\Contracts\Queries\Executors\MovimientoQueryExecutorContract;
use App\Infrastructure\Movimiento\Queries\Executors\Eloquent\EloquentListAllMovimientoWithDetailsExecutor;
use App\Application\Movimiento\Queries\Handlers\GetMovimientoRecordsCountHandler;
use App\Application\Movimiento\Queries\Handlers\GetEspontaneoMovimientoRecordsCountHandler;
use App\Application\Movimiento\Contracts\Queries\Executors\GetMovimientoRecordsCountQueryExecutorContract;
use App\Infrastructure\Movimiento\Queries\Executors\Eloquent\EloquentGetMovimientoRecordsCountQueryExecutor;
use App\Infrastructure\Movimiento\Queries\Executors\Eloquent\EloquentGetEspontaneoMovimientoRecordsCountQueryExecutor;
use App\Application\Movimiento\Queries\Handlers\ListMovimientoForTableHandler;
use App\Infrastructure\Movimiento\Queries\Executors\Eloquent\EloquentMovimientoPaginatedTableQueryExecutor;
use App\Application\Movimiento\Contracts\Queries\Executors\MovimientoPaginatedTableQueryExecutorContract;

final class MovimientoQueryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->when(ListAllMovimientoWithDetailsHandler::class)
            ->needs(MovimientoQueryExecutorContract::class)
            ->give(EloquentListAllMovimientoWithDetailsExecutor::class);

        $this->app->when(GetMovimientoRecordsCountHandler::class)
            ->needs(GetMovimientoRecordsCountQueryExecutorContract::class)
            ->give(EloquentGetMovimientoRecordsCountQueryExecutor::class);

        $this->app->when(GetEspontaneoMovimientoRecordsCountHandler::class)
            ->needs(GetMovimientoRecordsCountQueryExecutorContract::class)
            ->give(EloquentGetEspontaneoMovimientoRecordsCountQueryExecutor::class);

        $this->app->when(ListMovimientoForTableHandler::class)
            ->needs(MovimientoPaginatedTableQueryExecutorContract::class)
            ->give(EloquentMovimientoPaginatedTableQueryExecutor::class);

        $this->app->singleton(MovimientoPaginatedTableQueryExecutorContract::class, EloquentMovimientoPaginatedTableQueryExecutor::class);
    }

    public function boot(): void
    {
        //
    }
}
