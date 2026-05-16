<?php

namespace App\Providers\Movimiento;

use App\Application\Movimiento\Contracts\Queries\Executors\GetAllArchivoMovimientosIdsForAMovimientoQueryExecutorContract;
use App\Infrastructure\ArchivoMovimiento\Queries\Executors\Eloquent\EloquentGetAllArchivoMovimientosIdsForAMovimientoQueryExecutorContract;
use Illuminate\Support\ServiceProvider;
use App\Application\Movimiento\Queries\Handlers\ListAllSpontaneousMovimientosWithDetailsHandler;
use App\Application\Movimiento\Contracts\Queries\Executors\MovimientoQueryExecutorContract;
use App\Infrastructure\Movimiento\Queries\Executors\Eloquent\EloquentListAllSpontaneousMovimientosWithDetailsExecutor;
use App\Application\Movimiento\Queries\Handlers\GetMovimientoRecordsCountHandler;
use App\Application\Movimiento\Queries\Handlers\GetSpontaneousMovimientoRecordsCountHandler;
use App\Application\Movimiento\Contracts\Queries\Executors\GetMovimientoRecordsCountQueryExecutorContract;
use App\Infrastructure\Movimiento\Queries\Executors\Eloquent\EloquentGetMovimientoRecordsCountQueryExecutor;
use App\Infrastructure\Movimiento\Queries\Executors\Eloquent\EloquentGetEspontaneoMovimientoRecordsCountQueryExecutor;
use App\Application\Movimiento\Queries\Handlers\ListMovimientoForTableHandler;
use App\Infrastructure\Movimiento\Queries\Executors\Eloquent\EloquentMovimientoPaginatedTableQueryExecutor;
use App\Application\Movimiento\Contracts\Queries\Executors\MovimientoPaginatedTableQueryExecutorContract;
use App\Application\Movimiento\Contracts\Queries\Executors\MovimientoForShowQueryExecutorContract;
use App\Infrastructure\Movimiento\Queries\Executors\Eloquent\EloquentMovimientoForShowQueryExecutor;
use App\Application\Movimiento\Contracts\Queries\Executors\GetAllArchivoMovimientosForAMovimientoQueryExecutorContract;
use App\Infrastructure\ArchivoMovimiento\Queries\Executors\Eloquent\EloquentGetAllArchivoMovimientosForAMovimientoQueryExecutorContract;
final class MovimientoQueryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->when(ListAllSpontaneousMovimientosWithDetailsHandler::class)
            ->needs(MovimientoQueryExecutorContract::class)
            ->give(EloquentListAllSpontaneousMovimientosWithDetailsExecutor::class);

        $this->app->when(GetMovimientoRecordsCountHandler::class)
            ->needs(GetMovimientoRecordsCountQueryExecutorContract::class)
            ->give(EloquentGetMovimientoRecordsCountQueryExecutor::class);

        $this->app->when(GetSpontaneousMovimientoRecordsCountHandler::class)
            ->needs(GetMovimientoRecordsCountQueryExecutorContract::class)
            ->give(EloquentGetEspontaneoMovimientoRecordsCountQueryExecutor::class);

        $this->app->when(ListMovimientoForTableHandler::class)
            ->needs(MovimientoPaginatedTableQueryExecutorContract::class)
            ->give(EloquentMovimientoPaginatedTableQueryExecutor::class);

        $this->app->singleton(MovimientoPaginatedTableQueryExecutorContract::class, EloquentMovimientoPaginatedTableQueryExecutor::class);
        $this->app->singleton(MovimientoForShowQueryExecutorContract::class, EloquentMovimientoForShowQueryExecutor::class);
        $this->app->singleton(GetAllArchivoMovimientosIdsForAMovimientoQueryExecutorContract::class, EloquentGetAllArchivoMovimientosIdsForAMovimientoQueryExecutorContract::class);
        $this->app->singleton(GetAllArchivoMovimientosForAMovimientoQueryExecutorContract::class, EloquentGetAllArchivoMovimientosForAMovimientoQueryExecutorContract::class);
    }

    public function boot(): void
    {
        //
    }
}
