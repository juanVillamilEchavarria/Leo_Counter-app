<?php

namespace App\Providers\Reporte;

use Illuminate\Support\ServiceProvider;
use App\Infrastructure\Reporte\Queries\Handlers\Presupuestos\Eloquent\EloquentTotalPresupuestoQueryHandler;
use App\Infrastructure\Reporte\Queries\Handlers\Presupuestos\Eloquent\EloquentUsedBudgetQueryHandler;

final class PresupuestoQueryHandlerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->tag([
            EloquentTotalPresupuestoQueryHandler::class,
            EloquentUsedBudgetQueryHandler::class,
        ], 'reporte.presupuesto.query.handlers');
    }
}
