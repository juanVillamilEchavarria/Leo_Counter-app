<?php

namespace App\Providers\MovimientoPendiente;

use App\Domains\MovimientoPendiente\Contracts\Repositories\MovimientoPendienteRepositoryContract;
use App\Infrastructure\MovimientoPendiente\Persistence\Repositories\Eloquent\EloquentMovimientoPendienteRepository;
use App\Shared\Application\Contracts\Queries\Executors\FormOptions\ListTipoMovimientoForFormContract;
use App\Infrastructure\TipoMovimiento\Queries\Executors\Eloquent\EloquentListTipoMovimientoForFormQueryExecutor;
use Illuminate\Support\ServiceProvider;

/**
 * Service provider del modulo MovimientoPendiente.
 * Registra bindings de repositorio y opciones de formulario requeridos por la capa de aplicacion.
 *
 * Centraliza la resolucion de dependencias de infraestructura para que los handlers y executors
 * de MovimientoPendiente reciban las implementaciones concretas correctas.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Providers\MovimientoPendiente
 * @since 1.0.0
 * @version 1.0.0
 */
final class MovimientoPendienteServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(MovimientoPendienteRepositoryContract::class, EloquentMovimientoPendienteRepository::class);
        $this->app->singleton(ListTipoMovimientoForFormContract::class, EloquentListTipoMovimientoForFormQueryExecutor::class);
    }

    public function boot(): void
    {
        //
    }
}
