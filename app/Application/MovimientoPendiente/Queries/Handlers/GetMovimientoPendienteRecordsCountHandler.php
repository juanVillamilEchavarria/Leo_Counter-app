<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\MovimientoPendiente\Queries\Handlers;

use App\Application\MovimientoPendiente\Contracts\Queries\Executors\GetMovimientoPendienteRecordsCountQueryExecutorContract;
use App\Application\MovimientoPendiente\Queries\GetMovimientoPendienteRecordsCountQuery;

/**
 * Handler encargado de obtener el conteo total de movimientos pendientes disponibles.
 * Mantiene el caso de uso de aplicacion separado de la consulta concreta a persistencia.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\MovimientoPendiente\Queries\Handlers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class GetMovimientoPendienteRecordsCountHandler
{
    public function __construct(
        private GetMovimientoPendienteRecordsCountQueryExecutorContract $executor,
    ) {
    }

    public function __invoke(GetMovimientoPendienteRecordsCountQuery $query): int
    {
        return $this->executor->execute();
    }
}
