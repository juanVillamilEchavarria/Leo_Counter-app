<?php

namespace App\Application\MovimientoPendiente\Queries\Handlers;
use App\Application\MovimientoPendiente\Contracts\Queries\Executors\MovimientoPendienteQueryExecutorContract;
use App\Application\MovimientoPendiente\Queries\ListAllMovimientoPendienteDueForProcessingQuery;
use App\Shared\Domain\Contracts\CollectionContract;

/**
 * Manejador para el query de obtencion de los movimientos pendientes que deben ser procesados
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\MovimientoPendiente\Queries\Handlers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class ListAllMovimientoPendienteDueForProcessingHandler
{
    public function __construct(
        private readonly MovimientoPendienteQueryExecutorContract $movimientoPendienteQueryExecutorContract
    )
    {
    }
    public function __invoke( ListAllMovimientoPendienteDueForProcessingQuery $query) : CollectionContract
    {
       return $this->movimientoPendienteQueryExecutorContract->execute($query);
    }

}
