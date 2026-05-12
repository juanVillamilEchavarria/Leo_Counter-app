<?php

namespace App\Application\Movimiento\Queries\Handlers;

use App\Application\Movimiento\Queries\ListAllSpontaneousMovimientosWithDetailsQuery;
use App\Application\Movimiento\Contracts\Queries\Executors\MovimientoQueryExecutorContract;
use App\Shared\Domain\Contracts\CollectionContract;

/**
 * Handler para la consulta de todos los movimientos con detalles.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class ListAllSpontaneousMovimientosWithDetailsHandler
{
    public function __construct(
        private MovimientoQueryExecutorContract $executor
    ){}

    public function __invoke(ListAllSpontaneousMovimientosWithDetailsQuery $query): CollectionContract
    {
        return $this->executor->execute($query);
    }
}
