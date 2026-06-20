<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Providers\Configuracion;

use Illuminate\Support\ServiceProvider;

class ConfiguracionResourcesProvider extends ServiceProvider
{
    private const DELETED_RESOURCE_STRATEGIES_TAG = 'configuracion.deleted_records.resource_strategies';
    /**
     * Register services.
     */
    public function register(): void
    {
        // Resource strategies tag and resolver
        $this->app->tag([
            \App\Infrastructure\Configuracion\Strategies\DeletedCategoriaRecordsResourceStrategy::class,
            \App\Infrastructure\Configuracion\Strategies\DeletedCuentaRecordsResourceStrategy::class,
            \App\Infrastructure\Configuracion\Strategies\DeletedMovimientoPendienteRecordsResourceStrategy::class,
            \App\Infrastructure\Configuracion\Strategies\DeletedPresupuestoRecordsResourceStrategy::class,
        ], self::DELETED_RESOURCE_STRATEGIES_TAG);



        $this->app->singleton(\App\Infrastructure\Configuracion\Resolvers\DeletedRecordsResourceResolver::class, function ($app) {
            return new \App\Infrastructure\Configuracion\Resolvers\DeletedRecordsResourceResolver(
                $app->tagged(self::DELETED_RESOURCE_STRATEGIES_TAG)
            );
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
