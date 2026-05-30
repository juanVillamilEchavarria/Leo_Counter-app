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
use App\Infrastructure\Reporte\Resolvers\Queries\Handlers\PresupuestoQueryRelationResolver;
use App\Infrastructure\Reporte\Queries\Modifiers\Laravel\Presupuestos\PresupuestoCategoriaQueryIdRelationStrategy;
use App\Infrastructure\Reporte\Queries\Modifiers\Laravel\Presupuestos\PresupuestoOnlyFixedCategoriesQueryRelationStrategy;

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
