<?php

namespace App\Providers\Infrastructure\Reporte;

use Illuminate\Support\ServiceProvider;
use App\Infrastructure\QueryHandlers\Reporte\Presupuesto\Resolvers\PresupuestoQueryHandlerResolver;
use App\Infrastructure\QueryHandlers\Reporte\Presupuesto\Eloquent\EloquentTotalPresupuestoQueryHandler;

class PresupuestoQueryHandlerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->tag([
            EloquentTotalPresupuestoQueryHandler::class,
        ], 'reporte.presupuesto.query.handlers');

        $this->app->bind(
            PresupuestoQueryHandlerResolver::class,
            fn($app) => new PresupuestoQueryHandlerResolver(
                $app->tagged('reporte.presupuesto.query.handlers')
            )
        );
    }
}
