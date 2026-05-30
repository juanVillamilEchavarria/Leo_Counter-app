<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Movimiento\Queries\Handlers;

use App\Application\Movimiento\Queries\GetSpontaneousMovimientoRecordsCountQuery;
use App\Application\Movimiento\Contracts\Queries\Executors\GetMovimientoRecordsCountQueryExecutorContract;

/**
 * Handler que obtiene el número de movimientos espontáneos (del día).
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class GetSpontaneousMovimientoRecordsCountHandler
{
    public function __construct(
        private GetMovimientoRecordsCountQueryExecutorContract $executor
    ){}

    public function __invoke(GetSpontaneousMovimientoRecordsCountQuery $query): int
    {
        return $this->executor->execute();
    }
}
