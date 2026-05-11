<?php

namespace App\Application\Movimiento\Queries\Handlers;

use App\Application\Movimiento\Queries\GetEspontaneoMovimientoRecordsCountQuery;
use App\Application\Movimiento\Contracts\Queries\Executors\GetMovimientoRecordsCountQueryExecutorContract;

/**
 * Handler que obtiene el número de movimientos espontáneos (del día).
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class GetEspontaneoMovimientoRecordsCountHandler
{
    public function __construct(
        private GetMovimientoRecordsCountQueryExecutorContract $executor
    ){}

    public function __invoke(GetEspontaneoMovimientoRecordsCountQuery $query): int
    {
        return $this->executor->execute();
    }
}
