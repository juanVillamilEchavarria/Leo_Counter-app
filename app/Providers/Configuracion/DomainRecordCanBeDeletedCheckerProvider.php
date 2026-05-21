<?php

namespace App\Providers\Configuracion;

use App\Domains\Configuracion\Contracts\Checkers\DomainRecordCanBeDeletedCheckerContract;
use App\Domains\Configuracion\Strategies\SoftDeleteCategoriaManager;
use App\Domains\Configuracion\Strategies\SoftDeleteCuentaManager;
use App\Domains\Configuracion\Strategies\SoftDeleteMovimientoPendienteManager;
use App\Infrastructure\Configuracion\Persistence\Checkers\Eloquent\EloquentCategoriaCanBeDeletedChecker;
use App\Infrastructure\Configuracion\Persistence\Checkers\Eloquent\EloquentCuentaCanBeDeletedChecker;
use Illuminate\Support\ServiceProvider;

class DomainRecordCanBeDeletedCheckerProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->when(SoftDeleteCategoriaManager::class)
            ->needs(DomainRecordCanBeDeletedCheckerContract::class)
            ->give(EloquentCategoriaCanBeDeletedChecker::class);
        $this->app->when(SoftDeleteCuentaManager::class )
            ->needs(DomainRecordCanBeDeletedCheckerContract::class)
            ->give(EloquentCuentaCanBeDeletedChecker::class );
        $this->app->when(SoftDeleteMovimientoPendienteManager::class)
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
