<?php

namespace App\Application\MovimientoPendiente\Queries\Handlers;

use App\Application\MovimientoPendiente\Contracts\Queries\Executors\MovimientoPendienteQueryExecutorContract;
use App\Application\MovimientoPendiente\Queries\ListAllMovimientoPendienteQuery;
use App\Shared\Domain\Contracts\CollectionContract;
use App\Application\MovimientoPendiente\Contracts\Enrichers\MovimientoPendienteCollectionEnricherContract;
use App\Domains\MovimientoPendiente\Contracts\GetAllAccountsBalanceForMovimientosPendientesContract;

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
        private GetAllAccountsBalanceForMovimientosPendientesContract $getAllAccountsBalanceForMovimientosPendientes,
        private MovimientoPendienteCollectionEnricherContract $enricher
    ) {
    }

    public function __invoke(ListAllMovimientoPendienteQuery $query): CollectionContract
    {
        $movimientosPendientes= $this->executor->execute($query);
        $accountsBalance = $this->getAllAccountsBalanceForMovimientosPendientes->getAllAccountsBalanceForMovimientosPendientes();
        return $this->enricher->enrich($movimientosPendientes, $accountsBalance);
    }
}
