<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\MovimientoPendiente\Queries\Executors\Eloquent;

use App\Application\MovimientoPendiente\Contracts\Queries\Executors\MovimientoPendienteQueryExecutorContract;
use App\Application\MovimientoPendiente\Contracts\Queries\ListMovimientoPendienteQueryContract;
use App\Domains\MovimientoPendiente\Enums\EstadosMovimientoPendiente;
use App\Models\MovimientoPendiente\MovimientoPendiente;
use App\Shared\Domain\Contracts\CollectionContract;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;

/**
 * Query executor Eloquent para listar movimientos pendientes con sus relaciones principales.
 * Ejecuta la consulta optimizada para lectura filtrando unicamente los pendientes
 * y devuelve una coleccion compatible con la capa de aplicacion.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Infrastructure\MovimientoPendiente\Queries\Executors\Eloquent
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class EloquentListAllMovimientoPendienteWithDetailsExecutor implements MovimientoPendienteQueryExecutorContract
{
    /**
     * Ejecuta la consulta de listado de movimientos pendientes con detalles de relacion.
     * Filtra por estado pendiente para mostrar unicamente los que aun no han sido realizados.
     *
     * @param ListMovimientoPendienteQueryContract $query Query de listado.
     * @return CollectionContract Coleccion de movimientos pendientes con relaciones cargadas.
     */
    public function execute(ListMovimientoPendienteQueryContract $query): CollectionContract
    {
        return LaravelCollection::make(
            MovimientoPendiente::with([
                'categoria',
                'cuenta',
                'tipo_movimiento',
                'movimiento_fijo',
            ])
                ->where('estado', EstadosMovimientoPendiente::PENDIENTE->value)
                ->get()
        );
    }
}
