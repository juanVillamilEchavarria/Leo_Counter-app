<?php

namespace App\Providers\Reporte;

use Illuminate\Support\ServiceProvider;
use App\Infrastructure\Reporte\Resolvers\Queries\Handlers\MovimientoQueryHandlerResolver;
use App\Infrastructure\Reporte\Queries\Handlers\Movimientos\Eloquent\EloquentGastosQueryHandler;
use App\Infrastructure\Reporte\Queries\Handlers\Movimientos\Eloquent\EloquentIngresosQueryHandler;
use App\Infrastructure\Reporte\Queries\Handlers\Movimientos\Eloquent\EloquentKPIsQueryHandler;
use App\Infrastructure\Reporte\Queries\Handlers\Movimientos\Eloquent\EloquentIngresosVsGastosQueryHandler;
use App\Infrastructure\Reporte\Queries\Handlers\Movimientos\Eloquent\EloquentCategoryDistributionQueryHandler;
use App\Infrastructure\Reporte\Queries\Handlers\Movimientos\Eloquent\EloquentBalanceNetoQueryHandler;

final class MovimientoQueryHandlerServiceProvider extends ServiceProvider
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
