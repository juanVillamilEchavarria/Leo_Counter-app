<?php

namespace App\Domains\Configuracion\Strategies\Providers;
use App\Domains\Configuracion\Strategies\Resolvers\SoftDeleteManagerResolver;
use App\Domains\Configuracion\Strategies\Domain\SoftDeleteManagers\Categoria\SoftDeleteCategoriaManager;
use App\Domains\Configuracion\Strategies\Domain\SoftDeleteManagers\Cuenta\SoftDeleteCuentaManager;
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
