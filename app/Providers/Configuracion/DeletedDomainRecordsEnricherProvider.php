<?php

namespace App\Providers\Configuracion;

use App\Application\Configuracion\Strategies\ListDeletedCategoriaRecordsStrategy;
use App\Application\Configuracion\Strategies\ListDeletedCuentaRecordsStrategy;
use App\Application\Configuracion\Strategies\ListDeletedMovimientoPendienteRecordsStrategy;
use App\Application\Configuracion\Strategies\ListDeletedPresupuestoRecordsStrategy;
use App\Domains\Configuracion\Contracts\Checkers\DomainRecordCanBeDeletedCheckerContract;
use App\Infrastructure\Configuracion\Persistence\Checkers\Eloquent\EloquentCategoriaCanBeDeletedChecker;
use Illuminate\Support\ServiceProvider;

class DeletedDomainRecordsEnricherProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
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
        $this->app->when(\App\Infrastructure\Configuracion\Queries\Enrichers\LaravelMovimientoPendienteDeletedEnricher::class)
            ->needs(DomainRecordCanBeDeletedCheckerContract::class)
            ->give(\App\Infrastructure\Configuracion\Persistence\Checkers\Eloquent\EloquentMovimientoPendienteCanBeDeletedChecker::class);
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
