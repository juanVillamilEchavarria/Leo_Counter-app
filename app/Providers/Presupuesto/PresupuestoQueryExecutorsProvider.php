<?php

namespace App\Providers\Presupuesto;

use App\Application\Presupuesto\Contracts\Queries\Executors\PresupuestoPaginatedTableQueryExecutorContract;
use Illuminate\Support\ServiceProvider;
use App\Application\Presupuesto\Queries\Handlers\ListPresupuestosWithDetailsHandler;
use App\Application\Presupuesto\Queries\Handlers\GetPresupuestosRecordsCountHandler;
use App\Application\Presupuesto\Queries\Handlers\ListPresupuestoFormOptionsHandler;
use App\Application\Presupuesto\Queries\Handlers\ListPresupuestosPaginatedHandler;
use App\Application\Presupuesto\Contracts\Queries\Executors\PresupuestoQueryExecutorContract;
use App\Application\Presupuesto\Contracts\Queries\Executors\GetPresupuestoRecordsCountQueryExecutorContract;
use App\Application\Presupuesto\Contracts\Queries\Executors\ListPresupuestoFormOptionsQueryExecutorContract;
use App\Application\Presupuesto\Contracts\Queries\Executors\GetPresupuestosPaginatedQueryExecutorContract;
use App\Application\Presupuesto\Queries\Handlers\GetCurrentMonthPresupuestosRecordsCountHandler;
use App\Application\Presupuesto\Queries\Handlers\GetHistoricPresupuestosRecordsCountHandler;
use App\Application\Presupuesto\Queries\Handlers\ListAllCurrentMonthPresupuestosHandler;
use App\Infrastructure\Presupuesto\Queries\Executors\Eloquent\EloquentListAllPresupuestosWithDetailsQueryExecutor;
use App\Infrastructure\Presupuesto\Queries\Executors\Eloquent\EloquentGetPresupuestoRecordsCountQueryExecutor;
use App\Infrastructure\Presupuesto\Queries\Executors\Eloquent\EloquentListPresupuestoFormOptionsQueryExecutor;
use App\Infrastructure\Presupuesto\Queries\Executors\Eloquent\EloquentGetPresupuestosPaginatedQueryExecutor;
use App\Application\Presupuesto\Queries\Handlers\ListHistoricPresupuestosForTableHandler;
use App\Infrastructure\Presupuesto\Queries\Executors\Eloquent\EloquentGetCurrentMonthPresupuestoRecordsCountQueryExecutor;
use App\Infrastructure\Presupuesto\Queries\Executors\Eloquent\EloquentGetHistoricPresupuestoRecordsCountQueryExecutor;
use App\Infrastructure\Presupuesto\Queries\Executors\Eloquent\EloquentListAllCurrentMonthPresupuestosWithDetailsQueryExecutor;
use App\Infrastructure\Presupuesto\Queries\Executors\Eloquent\EloquentPresupuestoPaginatedTableQueryExecutor;
use App\Application\Presupuesto\Contracts\Queries\CurrentMonthPresupuestoCollectionEnricherContract;
use App\Infrastructure\Presupuesto\Queries\Enrichers\LaravelCurrentMonthPresupuestoCollectionEnricher;

final class PresupuestoQueryExecutorsProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->when(ListHistoricPresupuestosForTableHandler::class)
            ->needs(PresupuestoQueryExecutorContract::class)
            ->give(EloquentPresupuestoPaginatedTableQueryExecutor::class);

        $this->app->when(GetCurrentMonthPresupuestosRecordsCountHandler::class)
            ->needs(GetPresupuestoRecordsCountQueryExecutorContract::class)
            ->give(EloquentGetCurrentMonthPresupuestoRecordsCountQueryExecutor::class);
            $this->app->when(GetHistoricPresupuestosRecordsCountHandler::class)
            ->needs(GetPresupuestoRecordsCountQueryExecutorContract::class)
            ->give(EloquentGetHistoricPresupuestoRecordsCountQueryExecutor::class);


        $this->app->when(ListAllCurrentMonthPresupuestosHandler::class)
            ->needs(PresupuestoQueryExecutorContract::class)
            ->give(EloquentListAllCurrentMonthPresupuestosWithDetailsQueryExecutor::class);

        // Inyectar el enricher concreto cuando el handler de listado del mes actual lo requiera
        $this->app->when(ListAllCurrentMonthPresupuestosHandler::class)
            ->needs(CurrentMonthPresupuestoCollectionEnricherContract::class)
            ->give(LaravelCurrentMonthPresupuestoCollectionEnricher::class);
        $this->app->singleton(PresupuestoPaginatedTableQueryExecutorContract::class, EloquentPresupuestoPaginatedTableQueryExecutor::class);
    }

    public function boot(): void
    {
        //
    }
}
