<?php

namespace App\Providers\Reporte;

use Illuminate\Support\ServiceProvider;
use App\Infrastructure\Reporte\Resolvers\Queries\Handlers\PresupuestoQueryHandlerResolver;
use App\Infrastructure\Reporte\Queries\Handlers\Presupuestos\Eloquent\EloquentTotalPresupuestoQueryHandler;

final class PresupuestoQueryHandlerServiceProvider extends ServiceProvider
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
