<?php

namespace App\Providers\Infrastructure\Reporte;

use Illuminate\Support\ServiceProvider;
use App\Infrastructure\QueryHandlers\Reporte\Presupuesto\Resolvers\PresupuestoQueryRelationResolver;
use App\Domains\Reporte\Strategies\Domain\Relations\Presupuestos\PresupuestoCategoriaQueryIdRelationStrategy;
use App\Domains\Reporte\Strategies\Domain\Relations\Presupuestos\PresupuestoOnlyFixedCategoriesQueryRelationStrategy;

class PresupuestoQueryRelationServiceProvider extends ServiceProvider
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
