<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Configuracion\Strategies;

use App\Application\Configuracion\Contracts\Queries\ListDeletedDomainRecordsContract;
use App\Application\Configuracion\Queries\ListAllMovimientosPendientesDeletedQuery;
use App\Application\MovimientoPendiente\Contracts\Queries\Executors\MovimientoPendienteQueryExecutorContract;
use App\Domains\Configuracion\Enums\SoftDeleteManagerTypes;
use App\Shared\Domain\Contracts\CollectionContract;

/**
 * Estrategia de listado de movimientos pendientes eliminados.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Infrastructure\Configuracion\Queries\Strategies
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class ListDeletedMovimientoPendienteRecordsStrategy implements ListDeletedDomainRecordsContract
{
    public function __construct(
        private MovimientoPendienteQueryExecutorContract $executor,
        private \App\Application\Configuracion\Contracts\Queries\Enrichers\DeletedDomainRecordsEnricherContract $enricher
    ) {
    }

    public function supports(SoftDeleteManagerTypes $type): bool
    {
        return $type === SoftDeleteManagerTypes::MOVIMIENTOS_PENDIENTES;
    }

    public function execute(): CollectionContract
    {
        $result = $this->executor->execute(new ListAllMovimientosPendientesDeletedQuery());

        assert($result instanceof CollectionContract);

        return $this->enricher->enrich($result);
    }
}
