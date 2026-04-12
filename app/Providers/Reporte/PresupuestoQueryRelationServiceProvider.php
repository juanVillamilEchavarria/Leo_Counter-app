<?php

namespace App\Providers\Reporte;

use Illuminate\Support\ServiceProvider;
use App\Infrastructure\Reporte\Resolvers\Queries\Handlers\PresupuestoQueryRelationResolver;
use App\Infrastructure\Reporte\Strategies\Relations\Presupuestos\PresupuestoCategoriaQueryIdRelationStrategy;
use App\Infrastructure\Reporte\Strategies\Relations\Presupuestos\PresupuestoOnlyFixedCategoriesQueryRelationStrategy;

final class PresupuestoQueryRelationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->tag([
            PresupuestoCategoriaQueryIdRelationStrategy::class,
            PresupuestoOnlyFixedCategoriesQueryRelationStrategy::class,
        ], 'reporte.presupuesto.relation.strategies');

        $this->app->bind(
            PresupuestoQueryRelationResolver::class,
            fn($app) => new PresupuestoQueryRelationResolver(
                $app->tagged('reporte.presupuesto.relation.strategies')
            )
        );
    }
}
