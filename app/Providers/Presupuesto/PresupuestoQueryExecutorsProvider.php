<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */

namespace App\Providers\Presupuesto;

use App\Application\Presupuesto\Contracts\Queries\CurrentMonthPresupuestoCollectionEnricherContract;
use App\Application\Presupuesto\Contracts\Queries\Executors\GetPresupuestoRecordsCountQueryExecutorContract;
use App\Application\Presupuesto\Contracts\Queries\Executors\PresupuestoPaginatedTableQueryExecutorContract;
use App\Application\Presupuesto\Contracts\Queries\Executors\PresupuestoQueryExecutorContract;
use App\Application\Presupuesto\Queries\Handlers\GetCurrentMonthPresupuestosRecordsCountHandler;
use App\Application\Presupuesto\Queries\Handlers\GetHistoricPresupuestosRecordsCountHandler;
use App\Application\Presupuesto\Queries\Handlers\ListAllCurrentMonthPresupuestosHandler;
use App\Application\Presupuesto\Queries\Handlers\ListHistoricPresupuestosForTableHandler;
use App\Infrastructure\Presupuesto\Queries\Enrichers\LaravelCurrentMonthPresupuestoCollectionEnricher;
use App\Infrastructure\Presupuesto\Queries\Executors\Eloquent\EloquentGetCurrentMonthPresupuestoRecordsCountQueryExecutor;
use App\Infrastructure\Presupuesto\Queries\Executors\Eloquent\EloquentGetHistoricPresupuestoRecordsCountQueryExecutor;
use App\Infrastructure\Presupuesto\Queries\Executors\Eloquent\EloquentListAllCurrentMonthPresupuestosWithDetailsQueryExecutor;
use App\Infrastructure\Presupuesto\Queries\Executors\Eloquent\EloquentPresupuestoPaginatedTableQueryExecutor;
use App\Infrastructure\Presupuesto\Queries\Strategies\EloquentPresupuestoExportQueryStrategy;
use Illuminate\Support\ServiceProvider;

final class PresupuestoQueryExecutorsProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->tag([
            EloquentPresupuestoExportQueryStrategy::class,
        ], 'export.query.strategies');

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
