<?php

namespace App\Domains\Reporte\Strategies\Providers\Relations;

use App\Domains\Reporte\Strategies\Domain\Relations\Movimientos\MovimientoCategoriaQueryIdRelationStrategy;
use App\Domains\Reporte\Strategies\Domain\Relations\Movimientos\MovimientoCuentaQueryIdRelationStrategy;
use App\Domains\Reporte\Strategies\Domain\Relations\Presupuestos\PresupuestoCategoriaQueryIdRelationStrategy;
use App\Domains\Reporte\Strategies\Resolvers\Relations\QueryIdRelationResolver;
use Illuminate\Support\ServiceProvider;

class QueryIdRelationStrategyProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(QueryIdRelationResolver::class, function () {
            return new QueryIdRelationResolver([
                new MovimientoCuentaQueryIdRelationStrategy(),
                new MovimientoCategoriaQueryIdRelationStrategy(),
                new PresupuestoCategoriaQueryIdRelationStrategy(),
            ]);
        });
    }
}