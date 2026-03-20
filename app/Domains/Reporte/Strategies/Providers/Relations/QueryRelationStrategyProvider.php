<?php

namespace App\Domains\Reporte\Strategies\Providers\Relations;

use App\Domains\Reporte\Strategies\Domain\Relations\Movimientos\MovimientoCategoriaQueryIdRelationStrategy;
use App\Domains\Reporte\Strategies\Domain\Relations\Movimientos\MovimientoCuentaQueryIdRelationStrategy;
use App\Domains\Reporte\Strategies\Domain\Relations\Movimientos\MovimientoOnlyFixedCategoriesQueryJoinRelationStrategy;
use App\Domains\Reporte\Strategies\Domain\Relations\Movimientos\MovimientoTipoMovimientoQueryJoinRelationStrategy;
use App\Domains\Reporte\Strategies\Domain\Relations\Movimientos\MovimientoCategoriaQueryJoinRelationStrategy;
use App\Domains\Reporte\Strategies\Domain\Relations\Presupuestos\PresupuestoCategoriaQueryIdRelationStrategy;
use App\Domains\Reporte\Strategies\Domain\Relations\Presupuestos\PresupuestoOnlyFixedCategoriesQueryRelationStrategy;
use App\Domains\Reporte\Strategies\Resolvers\Relations\QueryRelationResolver;
use Illuminate\Support\ServiceProvider;

class QueryRelationStrategyProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(QueryRelationResolver::class, function () {
            return new QueryRelationResolver([
                new MovimientoCuentaQueryIdRelationStrategy(),
                new MovimientoCategoriaQueryIdRelationStrategy(),
                new MovimientoOnlyFixedCategoriesQueryJoinRelationStrategy(),
                new MovimientoTipoMovimientoQueryJoinRelationStrategy(),
                new MovimientoCategoriaQueryJoinRelationStrategy(),
                new PresupuestoCategoriaQueryIdRelationStrategy(),
                new PresupuestoOnlyFixedCategoriesQueryRelationStrategy(),
            ]);
        });
    }
}