<?php

namespace App\Providers\Reporte;

use Illuminate\Support\ServiceProvider;
use App\Infrastructure\Reporte\Resolvers\Queries\Handlers\MovimientoQueryRelationResolver;
use App\Infrastructure\Reporte\Queries\Modifiers\Laravel\Movimientos\MovimientoCuentaQueryIdRelationStrategy;
use App\Infrastructure\Reporte\Queries\Modifiers\Laravel\Movimientos\MovimientoCategoriaQueryIdRelationStrategy;
use App\Infrastructure\Reporte\Queries\Modifiers\Laravel\Movimientos\MovimientoOnlyFixedCategoriesQueryJoinRelationStrategy;
use App\Infrastructure\Reporte\Queries\Modifiers\Laravel\Movimientos\MovimientoTipoMovimientoQueryJoinRelationStrategy;
use App\Infrastructure\Reporte\Queries\Modifiers\Laravel\Movimientos\MovimientoCategoriaQueryJoinRelationStrategy;

final class MovimientoQueryRelationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->tag([
            MovimientoCuentaQueryIdRelationStrategy::class,
            MovimientoCategoriaQueryIdRelationStrategy::class,
            MovimientoOnlyFixedCategoriesQueryJoinRelationStrategy::class,
            MovimientoTipoMovimientoQueryJoinRelationStrategy::class,
            MovimientoCategoriaQueryJoinRelationStrategy::class,
        ], 'reporte.movimiento.relation.strategies');

        $this->app->bind(
            MovimientoQueryRelationResolver::class,
            fn($app) => new MovimientoQueryRelationResolver(
                $app->tagged('reporte.movimiento.relation.strategies')
            )
        );
    }
}
