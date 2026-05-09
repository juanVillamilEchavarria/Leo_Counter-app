<?php

namespace App\Providers\MovimientoFijo;

use App\Application\MovimientoFijo\Queries\Handlers\ListMovimientoFijoFormOptionsHandler;
use App\Domains\Movimiento\Services\MovimientoQueryService;
use App\Domains\MovimientoFijo\Contracts\Repositories\MovimientoFijoRepositoryContract;
use App\Infrastructure\FrecuenciaMovimiento\Queries\Executors\EloquentListFrecuenciaMovimientoForForm;
use App\Infrastructure\MovimientoFijo\Persistence\Repositories\Eloquent\EloquentMovimientoFijoRepository;
use App\Infrastructure\MovimientoFijo\Queries\Executors\Eloquent\EloquentListActiveCuentaForMovimientoFijoForm;
use App\Infrastructure\TipoMovimiento\Queries\Executors\Eloquent\EloquentListTipoMovimientoForFormQueryExecutor;
use App\Shared\Application\Contracts\Queries\Executors\FormOptions\ListCuentaForFormContract;
use App\Shared\Application\Contracts\Queries\Executors\FormOptions\ListFrecuenciaMovimientoForFormContract;
use App\Shared\Application\Contracts\Queries\Executors\FormOptions\ListTipoMovimientoForFormContract;
use Illuminate\Support\ServiceProvider;

/**
 * Service provider del modulo MovimientoFijo.
 * Registra bindings de repositorio y opciones de formulario requeridos por la capa de aplicacion.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Providers\MovimientoFijo
 * @since 1.0.0
 * @version 1.0.0
 */
final class MovimientoFijoServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(MovimientoFijoRepositoryContract::class, EloquentMovimientoFijoRepository::class);
        $this->app->singleton(ListFrecuenciaMovimientoForFormContract::class, EloquentListFrecuenciaMovimientoForForm::class);
        $this->app->singleton(ListTipoMovimientoForFormContract::class, EloquentListTipoMovimientoForFormQueryExecutor::class);
    }

    public function boot(): void
    {
        //
    }
}
