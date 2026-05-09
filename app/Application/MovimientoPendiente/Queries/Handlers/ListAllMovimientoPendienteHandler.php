<?php

namespace App\Application\MovimientoPendiente\Queries\Handlers;

use App\Application\MovimientoPendiente\Contracts\Queries\Executors\MovimientoPendienteQueryExecutorContract;
use App\Application\MovimientoPendiente\Queries\ListAllMovimientoPendienteQuery;
use App\Shared\Domain\Contracts\CollectionContract;

/**
 * Handler encargado de listar movimientos pendientes con detalles.
 * Orquesta la consulta delegando la ejecucion SQL al query executor correspondiente.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\MovimientoPendiente\Queries\Handlers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class ListAllMovimientoPendienteHandler
{
    public function __construct(
        private MovimientoPendienteQueryExecutorContract $executor,
    ) {
    }

    public function __invoke(ListAllMovimientoPendienteQuery $query): CollectionContract
    {
        return $this->executor->execute($query);
    }
}
