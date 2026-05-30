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

use App\Application\MovimientoFijo\Contracts\Queries\Executors\MovimientoFijoQueryExecutorContract;
use App\Application\MovimientoFijo\Queries\ListAllMovimientoFijoQuery;
use App\Shared\Domain\Contracts\CollectionContract;

/**
 * Handler encargado de listar movimientos fijos con detalles.
 * Orquesta la consulta delegando la ejecucion SQL al query executor correspondiente.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\MovimientoFijo\Queries\Handlers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class ListAllMovimientoFijoHandler
{
    public function __construct(
        private MovimientoFijoQueryExecutorContract $executor,
    ) {
    }

    public function __invoke(ListAllMovimientoFijoQuery $query): CollectionContract
    {
        return $this->executor->execute($query);
    }
}
