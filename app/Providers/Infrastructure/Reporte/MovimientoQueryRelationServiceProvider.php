<?php

namespace App\Providers\Infrastructure\Reporte;

use Illuminate\Support\ServiceProvider;
use App\Infrastructure\QueryHandlers\Reporte\Movimiento\Resolvers\MovimientoQueryRelationResolver;
use App\Domains\Reporte\Strategies\Domain\Relations\Movimientos\MovimientoCuentaQueryIdRelationStrategy;
use App\Domains\Reporte\Strategies\Domain\Relations\Movimientos\MovimientoCategoriaQueryIdRelationStrategy;
use App\Domains\Reporte\Strategies\Domain\Relations\Movimientos\MovimientoOnlyFixedCategoriesQueryJoinRelationStrategy;
use App\Domains\Reporte\Strategies\Domain\Relations\Movimientos\MovimientoTipoMovimientoQueryJoinRelationStrategy;
use App\Domains\Reporte\Strategies\Domain\Relations\Movimientos\MovimientoCategoriaQueryJoinRelationStrategy;

class MovimientoQueryRelationServiceProvider extends ServiceProvider
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
