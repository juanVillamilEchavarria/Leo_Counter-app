<?php

namespace App\Providers\Reporte;

use Illuminate\Support\ServiceProvider;
use App\Infrastructure\Reporte\Queries\Executors\Movimientos\Eloquent\EloquentGastosQueryExecutor;
use App\Infrastructure\Reporte\Queries\Executors\Movimientos\Eloquent\EloquentIngresosQueryExecutor;
use App\Infrastructure\Reporte\Queries\Executors\Movimientos\Eloquent\EloquentKPIsQueryExecutor;
use App\Infrastructure\Reporte\Queries\Executors\Movimientos\Eloquent\EloquentIngresosVsGastosQueryExecutor;
use App\Infrastructure\Reporte\Queries\Executors\Movimientos\Eloquent\EloquentCategoryDistributionQueryExecutor;
use App\Infrastructure\Reporte\Queries\Executors\Movimientos\Eloquent\EloquentBalanceNetoQueryExecutor;

final class MovimientoQueryExecutorServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->tag([
            EloquentGastosQueryExecutor::class,
            EloquentIngresosQueryExecutor::class,
            EloquentKPIsQueryExecutor::class,
            EloquentIngresosVsGastosQueryExecutor::class,
            EloquentCategoryDistributionQueryExecutor::class,
            EloquentBalanceNetoQueryExecutor::class,
        ], 'reporte.movimiento.query.executors');
    }
}
