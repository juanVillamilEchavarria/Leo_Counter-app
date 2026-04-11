<?php

namespace App\Application\Configuracion\Providers\Strategies;
use App\Infrastructure\Persistence\Resolvers\SoftDeleteManagerResolver;
use App\Infrastructure\Persistence\Strategies\SoftDeleteManagers\Categoria\SoftDeleteCategoriaManager;
use App\Infrastructure\Persistence\Strategies\SoftDeleteManagers\Cuenta\SoftDeleteCuentaManager;
use App\Infrastructure\Persistence\Strategies\SoftDeleteManagers\MovimientoPendiente\SoftDeleteMovimientoPendienteManager;
use App\Infrastructure\Persistence\Strategies\SoftDeleteManagers\Presupuesto\SoftDeletePresupuestoManager;
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
