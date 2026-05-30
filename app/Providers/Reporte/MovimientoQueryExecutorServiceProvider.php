<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Providers\Reporte;

use Illuminate\Support\ServiceProvider;
use App\Infrastructure\Reporte\Queries\Executors\Movimientos\Eloquent\EloquentGastosQueryExecutor;
use App\Infrastructure\Reporte\Queries\Executors\Movimientos\Eloquent\EloquentIngresosQueryExecutor;
use App\Infrastructure\Reporte\Queries\Executors\Movimientos\Eloquent\EloquentKPIsQueryExecutor;
use App\Infrastructure\Reporte\Queries\Executors\Movimientos\Eloquent\EloquentIngresosVsGastosQueryExecutor;
use App\Infrastructure\Reporte\Queries\Executors\Movimientos\Eloquent\EloquentCategoryDistributionQueryExecutor;
use App\Infrastructure\Reporte\Queries\Executors\Movimientos\Eloquent\EloquentBalanceNetoQueryExecutor;
use App\Infrastructure\Reporte\Queries\Executors\Movimientos\Cache\CachedKPIsQueryExecutor;
use App\Infrastructure\Reporte\Queries\Executors\Movimientos\Cache\CachedIngresosVsGastosQueryExecutor;
use App\Infrastructure\Reporte\Queries\Executors\Movimientos\Cache\CachedBalanceNetoQueryExecutor;
use App\Infrastructure\Reporte\Queries\Executors\Movimientos\Cache\CachedCategoryDistributionQueryExecutor;
use App\Infrastructure\Reporte\Resolvers\Queries\Handlers\MovimientoQueryRelationResolver;

final class MovimientoQueryExecutorServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Bind decorated executors for caching
        $this->app->bind(EloquentKPIsQueryExecutor::class, function ($app) {
            return new CachedKPIsQueryExecutor(
                new EloquentKPIsQueryExecutor($app->make(MovimientoQueryRelationResolver::class))
            );
        });

        $this->app->bind(EloquentIngresosVsGastosQueryExecutor::class, function ($app) {
            return new CachedIngresosVsGastosQueryExecutor(
                new EloquentIngresosVsGastosQueryExecutor($app->make(MovimientoQueryRelationResolver::class))
            );
        });

        $this->app->bind(EloquentBalanceNetoQueryExecutor::class, function ($app) {
            return new CachedBalanceNetoQueryExecutor(
                new EloquentBalanceNetoQueryExecutor($app->make(MovimientoQueryRelationResolver::class))
            );
        });

        $this->app->bind(EloquentCategoryDistributionQueryExecutor::class, function ($app) {
            return new CachedCategoryDistributionQueryExecutor(
                new EloquentCategoryDistributionQueryExecutor($app->make(MovimientoQueryRelationResolver::class))
            );
        });

        // Register tag (including other executors left as-is)
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
