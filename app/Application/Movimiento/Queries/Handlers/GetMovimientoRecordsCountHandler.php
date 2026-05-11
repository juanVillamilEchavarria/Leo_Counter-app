<?php

namespace App\Application\Movimiento\Queries\Handlers;

use App\Application\Movimiento\Queries\GetMovimientoRecordsCountQuery;
use App\Application\Movimiento\Contracts\Queries\Executors\GetMovimientoRecordsCountQueryExecutorContract;

/**
 * Handler que obtiene el número total de movimientos.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class GetMovimientoRecordsCountHandler
{
    public function __construct(
        private GetMovimientoRecordsCountQueryExecutorContract $executor
    ){}

    public function __invoke(GetMovimientoRecordsCountQuery $query): int
    {
        return $this->executor->execute();
    }
}
