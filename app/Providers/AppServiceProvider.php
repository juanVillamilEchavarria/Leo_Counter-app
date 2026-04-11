<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Infrastructure\QueryHandlers\Reporte\Movimiento\Eloquent\EloquentKPIsQueryHandler;
use App\Infrastructure\QueryHandlers\Reporte\Movimiento\Eloquent\EloquentBalanceNetoQueryHandler;
use App\Infrastructure\QueryHandlers\Reporte\Movimiento\Eloquent\EloquentIngresosVsGastosQueryHandler;
use App\Infrastructure\QueryHandlers\Reporte\Movimiento\Eloquent\EloquentCategoryDistributionQueryHandler;
use App\Infrastructure\QueryHandlers\Reporte\Movimiento\Eloquent\EloquentIngresosQueryHandler;
use App\Infrastructure\QueryHandlers\Reporte\Movimiento\Eloquent\EloquentGastosQueryHandler;
use App\Infrastructure\QueryHandlers\Reporte\Presupuesto\Eloquent\EloquentTotalPresupuestoQueryHandler;
use App\Infrastructure\QueryHandlers\Reporte\Movimiento\Resolvers\MovimientoQueryHandlerResolver;
use App\Infrastructure\QueryHandlers\Reporte\Movimiento\Resolvers\MovimientoQueryRelationResolver;
use App\Infrastructure\QueryHandlers\Reporte\Presupuesto\Resolvers\PresupuestoQueryHandlerResolver;
use App\Infrastructure\QueryHandlers\Reporte\Presupuesto\Resolvers\PresupuestoQueryRelationResolver;
use App\Domains\Reporte\Resolvers\ReporteRepositoryResolver;
use App\Infrastructure\Persistence\Repositories\Eloquent\Reporte\EloquentMovimientoReporteRepository;
use App\Infrastructure\Persistence\Repositories\Eloquent\Reporte\EloquentPresupuestoReporteRepository;
use App\Application\Reporte\Support\ReporteFilterOptionsService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Movimiento handlers
        $this->app->tag([
            \App\Infrastructure\QueryHandlers\Reporte\Movimiento\Eloquent\EloquentGastosQueryHandler::class,
            // TODO: Move other handlers here
        ], 'movimiento.query.handlers');

        // Presupuesto handlers
        $this->app->tag([
            \App\Infrastructure\QueryHandlers\Reporte\Presupuesto\Eloquent\EloquentTotalPresupuestoQueryHandler::class,
        ], 'presupuesto.query.handlers');

        // Bind resolvers
        $this->app->bind(MovimientoQueryHandlerResolver::class, function ($app) {
            return new MovimientoQueryHandlerResolver(
                $app->tagged('movimiento.query.handlers')
            );
        });

        $this->app->bind(PresupuestoQueryHandlerResolver::class, function ($app) {
            return new PresupuestoQueryHandlerResolver(
                $app->tagged('presupuesto.query.handlers')
            );
        });

        $this->app->bind(MovimientoQueryRelationResolver::class, function ($app) {
            // TODO: Bind relation strategies
            return new MovimientoQueryRelationResolver([]);
        });

        $this->app->bind(PresupuestoQueryRelationResolver::class, function ($app) {
            // TODO: Bind relation strategies
            return new PresupuestoQueryRelationResolver([]);
        });

        // Bind repositories
        $this->app->bind(EloquentMovimientoReporteRepository::class, function ($app) {
            return new EloquentMovimientoReporteRepository(
                $app->make(MovimientoQueryHandlerResolver::class)
            );
        });

        $this->app->bind(EloquentPresupuestoReporteRepository::class, function ($app) {
            return new EloquentPresupuestoReporteRepository(
                $app->make(PresupuestoQueryHandlerResolver::class)
            );
        });

        // Repository resolver
        $this->app->bind(ReporteRepositoryResolver::class, function ($app) {
            return new ReporteRepositoryResolver([
                $app->make(EloquentMovimientoReporteRepository::class),
                $app->make(EloquentPresupuestoReporteRepository::class),
            ]);
        });

        $this->app->bind(\App\Application\Reporte\Support\ReporteFilterOptionsService::class, \App\Application\Reporte\Support\ReporteFilterOptionsService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
