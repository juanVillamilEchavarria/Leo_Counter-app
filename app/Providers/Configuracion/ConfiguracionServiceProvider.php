<?php

namespace App\Providers\Configuracion;

use App\Application\Categoria\Contracts\Queries\Executors\CategoriaQueryExecutorContract;
use App\Application\Configuracion\Resolvers\ListDeletedDomainRecordsResolver;
use App\Application\Configuracion\Strategies\ListDeletedCategoriaRecordsStrategy;
use App\Application\Configuracion\Strategies\ListDeletedCuentaRecordsStrategy;
use App\Application\Configuracion\Strategies\ListDeletedMovimientoPendienteRecordsStrategy;
use App\Application\Configuracion\Strategies\ListDeletedPresupuestoRecordsStrategy;
use App\Application\Cuenta\Contracts\Queries\Executors\CuentaQueryExecutorContract;
use App\Application\MovimientoPendiente\Contracts\Queries\Executors\MovimientoPendienteQueryExecutorContract;
use App\Application\Presupuesto\Contracts\Queries\Executors\PresupuestoQueryExecutorContract;
use App\Domains\Configuracion\Contracts\Checkers\DomainRecordCanBeDeletedCheckerContract;
use App\Domains\Configuracion\Strategies\SoftDeleteCategoriaManager;
use App\Infrastructure\Categoria\Queries\Executors\EloquentListAllCategoriasDeletedQueryExecutor;
use App\Infrastructure\Configuracion\Persistence\Checkers\Eloquent\EloquentCategoriaCanBeDeletedChecker;
use App\Infrastructure\Cuenta\Queries\Executors\Eloquent\EloquentListAllCuentasDeletedQueryExecutor;
use App\Infrastructure\MovimientoPendiente\Queries\Executors\Eloquent\EloquentListAllMovimientosPendientesDeletedQueryExecutor;
use App\Infrastructure\Presupuesto\Queries\Executors\Eloquent\EloquentListAllPresupuestosDeletedQueryExecutor;
use Illuminate\Support\ServiceProvider;

/**
 * Service provider de configuración para estrategias de lectura de registros eliminados.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Providers\Configuracion
 * @since 1.0.0
 * @version 1.0.0
 */
final class ConfiguracionServiceProvider extends ServiceProvider
{
    private const LIST_DELETED_STRATEGIES_TAG = 'configuracion.list_deleted_domain_records.strategies';
    private const DELETED_RESOURCE_STRATEGIES_TAG = 'configuracion.deleted_records.resource_strategies';

    public function register(): void
    {
        $this->app->when(SoftDeleteCategoriaManager::class)
            ->needs(DomainRecordCanBeDeletedCheckerContract::class)
            ->give(EloquentCategoriaCanBeDeletedChecker::class);

        // Enricher bindings for strategies
        $this->app->when(ListDeletedCategoriaRecordsStrategy::class)
            ->needs(\App\Application\Configuracion\Contracts\Queries\Enrichers\DeletedDomainRecordsEnricherContract::class)
            ->give(\App\Infrastructure\Configuracion\Queries\Enrichers\LaravelCategoriaDeletedEnricher::class);

        $this->app->when(ListDeletedCuentaRecordsStrategy::class)
            ->needs(\App\Application\Configuracion\Contracts\Queries\Enrichers\DeletedDomainRecordsEnricherContract::class)
            ->give(\App\Infrastructure\Configuracion\Queries\Enrichers\LaravelCuentaDeletedEnricher::class);

        $this->app->when(ListDeletedPresupuestoRecordsStrategy::class)
            ->needs(\App\Application\Configuracion\Contracts\Queries\Enrichers\DeletedDomainRecordsEnricherContract::class)
            ->give(\App\Infrastructure\Configuracion\Queries\Enrichers\LaravelPresupuestoDeletedEnricher::class);

        $this->app->when(ListDeletedMovimientoPendienteRecordsStrategy::class)
            ->needs(\App\Application\Configuracion\Contracts\Queries\Enrichers\DeletedDomainRecordsEnricherContract::class)
            ->give(\App\Infrastructure\Configuracion\Queries\Enrichers\LaravelMovimientoPendienteDeletedEnricher::class);

        // Enricher -> checker bindings
        $this->app->when(\App\Infrastructure\Configuracion\Queries\Enrichers\LaravelCategoriaDeletedEnricher::class)
            ->needs(DomainRecordCanBeDeletedCheckerContract::class)
            ->give(EloquentCategoriaCanBeDeletedChecker::class);

        $this->app->when(\App\Infrastructure\Configuracion\Queries\Enrichers\LaravelCuentaDeletedEnricher::class)
            ->needs(DomainRecordCanBeDeletedCheckerContract::class)
            ->give(\App\Infrastructure\Configuracion\Persistence\Checkers\Eloquent\EloquentCuentaCanBeDeletedChecker::class);

        $this->app->when(\App\Infrastructure\Configuracion\Queries\Enrichers\LaravelPresupuestoDeletedEnricher::class)
            ->needs(DomainRecordCanBeDeletedCheckerContract::class)
            ->give(\App\Infrastructure\Configuracion\Persistence\Checkers\Eloquent\EloquentPresupuestoCanBeDeletedChecker::class);

        // Original executor bindings
        $this->app->when(ListDeletedCategoriaRecordsStrategy::class)
            ->needs(CategoriaQueryExecutorContract::class)
            ->give(EloquentListAllCategoriasDeletedQueryExecutor::class);

        $this->app->when(ListDeletedCuentaRecordsStrategy::class)
            ->needs(CuentaQueryExecutorContract::class)
            ->give(EloquentListAllCuentasDeletedQueryExecutor::class);

        $this->app->when(ListDeletedPresupuestoRecordsStrategy::class)
            ->needs(PresupuestoQueryExecutorContract::class)
            ->give(EloquentListAllPresupuestosDeletedQueryExecutor::class);

        $this->app->when(ListDeletedMovimientoPendienteRecordsStrategy::class)
            ->needs(MovimientoPendienteQueryExecutorContract::class)
            ->give(EloquentListAllMovimientosPendientesDeletedQueryExecutor::class);

        $this->app->tag([
            ListDeletedCategoriaRecordsStrategy::class,
            ListDeletedCuentaRecordsStrategy::class,
            ListDeletedMovimientoPendienteRecordsStrategy::class,
            ListDeletedPresupuestoRecordsStrategy::class,
        ], self::LIST_DELETED_STRATEGIES_TAG);

        // Resource strategies tag and resolver
        $this->app->tag([
            \App\Infrastructure\Configuracion\Resources\DeletedCategoriaRecordsResourceStrategy::class,
            \App\Infrastructure\Configuracion\Resources\DeletedCuentaRecordsResourceStrategy::class,
            \App\Infrastructure\Configuracion\Resources\DeletedMovimientoPendienteRecordsResourceStrategy::class,
            \App\Infrastructure\Configuracion\Resources\DeletedPresupuestoRecordsResourceStrategy::class,
        ], self::DELETED_RESOURCE_STRATEGIES_TAG);

        $this->app->singleton(ListDeletedDomainRecordsResolver::class, function ($app) {
            return new ListDeletedDomainRecordsResolver(
                $app->tagged(self::LIST_DELETED_STRATEGIES_TAG),
            );
        });

        $this->app->singleton(\App\Application\Configuracion\Resolvers\DeletedRecordsResourceResolver::class, function ($app) {
            return new \App\Application\Configuracion\Resolvers\DeletedRecordsResourceResolver(
                $app->tagged(self::DELETED_RESOURCE_STRATEGIES_TAG)
            );
        });
    }
}
