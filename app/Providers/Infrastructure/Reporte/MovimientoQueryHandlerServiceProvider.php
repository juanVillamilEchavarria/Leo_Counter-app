<?php

namespace App\Providers\Infrastructure\Reporte;

use Illuminate\Support\ServiceProvider;
use App\Infrastructure\QueryHandlers\Reporte\Movimiento\Resolvers\MovimientoQueryHandlerResolver;
use App\Infrastructure\QueryHandlers\Reporte\Movimiento\Eloquent\EloquentGastosQueryHandler;
use App\Infrastructure\QueryHandlers\Reporte\Movimiento\Eloquent\EloquentIngresosQueryHandler;
use App\Infrastructure\QueryHandlers\Reporte\Movimiento\Eloquent\EloquentKPIsQueryHandler;
use App\Infrastructure\QueryHandlers\Reporte\Movimiento\Eloquent\EloquentIngresosVsGastosQueryHandler;
use App\Infrastructure\QueryHandlers\Reporte\Movimiento\Eloquent\EloquentCategoryDistributionQueryHandler;
use App\Infrastructure\QueryHandlers\Reporte\Movimiento\Eloquent\EloquentBalanceNetoQueryHandler;

class MovimientoQueryHandlerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->tag([
            EloquentGastosQueryHandler::class,
            EloquentIngresosQueryHandler::class,
            EloquentKPIsQueryHandler::class,
            EloquentIngresosVsGastosQueryHandler::class,
            EloquentCategoryDistributionQueryHandler::class,
            EloquentBalanceNetoQueryHandler::class,
        ], 'reporte.movimiento.query.handlers');

        $this->app->bind(
            MovimientoQueryHandlerResolver::class,
            fn($app) => new MovimientoQueryHandlerResolver(
                $app->tagged('reporte.movimiento.query.handlers')
            )
        );
    }
}
