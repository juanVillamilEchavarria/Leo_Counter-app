<?php

namespace App\Providers\Reporte;

use Illuminate\Support\ServiceProvider;
use App\Infrastructure\Reporte\Queries\Executors\Presupuestos\Eloquent\EloquentTotalPresupuestoQueryExecutor;
use App\Infrastructure\Reporte\Queries\Executors\Presupuestos\Eloquent\EloquentUsedBudgetQueryExecutor;

final class PresupuestoQueryExecutorServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->tag([
            EloquentTotalPresupuestoQueryExecutor::class,
            EloquentUsedBudgetQueryExecutor::class,
        ], 'reporte.presupuesto.query.executors');
    }
}
