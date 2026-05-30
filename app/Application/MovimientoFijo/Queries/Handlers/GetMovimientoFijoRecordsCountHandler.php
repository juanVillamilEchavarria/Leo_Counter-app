<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\MovimientoFijo\Queries\Handlers;

use App\Application\MovimientoFijo\Contracts\Queries\Executors\GetMovimientoFijoRecordsCountQueryExecutorContract;
use App\Application\MovimientoFijo\Queries\GetMovimientoFijoRecordsCountQuery;

/**
 * Handler encargado de obtener el conteo total de movimientos fijos.
 * Mantiene el caso de uso de aplicacion separado de la consulta concreta a persistencia.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\MovimientoFijo\Queries\Handlers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class GetMovimientoFijoRecordsCountHandler
{
    public function __construct(
        private GetMovimientoFijoRecordsCountQueryExecutorContract $executor,
    ) {
    }

    public function __invoke(GetMovimientoFijoRecordsCountQuery $query): int
    {
        return $this->executor->execute();
    }
}
