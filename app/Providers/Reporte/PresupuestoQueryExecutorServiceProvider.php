<?php

namespace App\Providers\Reporte;

use Illuminate\Support\ServiceProvider;
use App\Infrastructure\Reporte\Queries\Executors\Presupuestos\Eloquent\EloquentTotalPresupuestoQueryExecutor;
use App\Infrastructure\Reporte\Queries\Executors\Presupuestos\Eloquent\EloquentUsedBudgetQueryExecutor;
use App\Infrastructure\Reporte\Queries\Executors\Presupuestos\Cache\CachedTotalPresupuestoQueryExecutor;
use App\Infrastructure\Reporte\Queries\Executors\Presupuestos\Cache\CachedUsedBudgetQueryExecutor;
use App\Infrastructure\Reporte\Resolvers\Queries\Handlers\PresupuestoQueryRelationResolver;

final class PresupuestoQueryExecutorServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Bind decorated ejecutors for presupuestos
        $this->app->bind(EloquentTotalPresupuestoQueryExecutor::class, function ($app) {
            return new CachedTotalPresupuestoQueryExecutor(
                new EloquentTotalPresupuestoQueryExecutor($app->make(PresupuestoQueryRelationResolver::class))
            );
        });

        $this->app->bind(EloquentUsedBudgetQueryExecutor::class, function ($app) {
            return new CachedUsedBudgetQueryExecutor(
                new EloquentUsedBudgetQueryExecutor($app->make(PresupuestoQueryRelationResolver::class))
            );
        });

        $this->app->tag([
            EloquentTotalPresupuestoQueryExecutor::class,
            EloquentUsedBudgetQueryExecutor::class,
        ], 'reporte.presupuesto.query.executors');
    }
}
