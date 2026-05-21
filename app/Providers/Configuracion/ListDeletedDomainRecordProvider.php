<?php

namespace App\Providers\Configuracion;

use App\Application\Configuracion\Resolvers\ListDeletedDomainRecordsResolver;
use App\Application\Configuracion\Strategies\ListDeletedCategoriaRecordsStrategy;
use App\Application\Configuracion\Strategies\ListDeletedCuentaRecordsStrategy;
use App\Application\Configuracion\Strategies\ListDeletedMovimientoPendienteRecordsStrategy;
use App\Application\Configuracion\Strategies\ListDeletedPresupuestoRecordsStrategy;
use Illuminate\Support\ServiceProvider;

class ListDeletedDomainRecordProvider extends ServiceProvider
{
    private const LIST_DELETED_STRATEGIES_TAG = 'configuracion.list_deleted_domain_records.strategies';
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->tag([
            ListDeletedCategoriaRecordsStrategy::class,
            ListDeletedCuentaRecordsStrategy::class,
            ListDeletedMovimientoPendienteRecordsStrategy::class,
            ListDeletedPresupuestoRecordsStrategy::class,
        ], self::LIST_DELETED_STRATEGIES_TAG);
        $this->app->singleton(ListDeletedDomainRecordsResolver::class, function ($app) {
            return new ListDeletedDomainRecordsResolver(
                $app->tagged(self::LIST_DELETED_STRATEGIES_TAG),
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
