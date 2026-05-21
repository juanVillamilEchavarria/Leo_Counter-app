<?php

namespace App\Providers\Configuracion;
use App\Application\Configuracion\Resolvers\SoftDeleteManagerResolver;
use App\Domains\Configuracion\Strategies\SoftDeleteCategoriaManager;
use App\Domains\Configuracion\Strategies\SoftDeleteCuentaManager;
use App\Domains\Configuracion\Strategies\SoftDeleteMovimientoPendienteManager;
use App\Domains\Configuracion\Strategies\SoftDeletePresupuestoManager;
use Illuminate\Support\ServiceProvider;

class SoftDeleteManagerProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(SoftDeleteManagerResolver::class, function ($app) {
            return new SoftDeleteManagerResolver([
                $app->make(SoftDeleteCuentaManager::class),
                $app->make(SoftDeleteCategoriaManager::class),
                $app->make(SoftDeleteMovimientoPendienteManager::class),
                $app->make(SoftDeletePresupuestoManager::class),
            ]);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
