<?php

namespace App\Infrastructure\MovimientoFijo\Queries\Executors\Eloquent;

use App\Application\MovimientoFijo\Contracts\Queries\Executors\MovimientoFijoQueryExecutorContract;
use App\Application\MovimientoFijo\Contracts\Queries\ListMovimientoFijoQueryContract;
use App\Models\MovimientoFijo\MovimientoFijo;
use App\Shared\Domain\Contracts\CollectionContract;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;

/**
 * Query executor Eloquent para listar movimientos fijos con sus relaciones principales.
 * Ejecuta la consulta optimizada para lectura y devuelve una coleccion compatible con la aplicacion.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Infrastructure\MovimientoFijo\Queries\Executors\Eloquent
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class EloquentListAllMovimientoFijoWithDetailsExecutor implements MovimientoFijoQueryExecutorContract
{
    public function execute(ListMovimientoFijoQueryContract $query): CollectionContract
    {
        return LaravelCollection::make(
            MovimientoFijo::with([
                'categoria',
                'cuenta',
                'tipo_movimiento',
                'frecuencia_movimiento',
            ])->get()
        );
    }
}
