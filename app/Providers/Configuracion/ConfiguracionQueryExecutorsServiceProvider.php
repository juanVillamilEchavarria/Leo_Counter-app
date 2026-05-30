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
use App\Infrastructure\Configuracion\Queries\Enrichers\LaravelMovimientoPendienteDeletedEnricher;
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
final class ConfiguracionQueryExecutorsServiceProvider extends ServiceProvider
{



    public function register(): void
    {





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




    }
}
