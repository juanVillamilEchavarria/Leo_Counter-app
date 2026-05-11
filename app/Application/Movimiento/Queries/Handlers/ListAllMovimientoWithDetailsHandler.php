<?php

namespace App\Application\Movimiento\Queries\Handlers;

use App\Application\Movimiento\Queries\ListAllMovimientoWithDetailsQuery;
use App\Application\Movimiento\Contracts\Queries\Executors\MovimientoQueryExecutorContract;
use App\Shared\Domain\Contracts\CollectionContract;

/**
 * Handler para la consulta de todos los movimientos con detalles.
 * Inyecta un executor concreto (desacoplado de Eloquent) que provee la colección.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class ListAllMovimientoWithDetailsHandler
{
    public function __construct(
        private MovimientoQueryExecutorContract $executor
    ){}

    public function __invoke(ListAllMovimientoWithDetailsQuery $query): CollectionContract
    {
        return $this->executor->execute($query);
    }
}
