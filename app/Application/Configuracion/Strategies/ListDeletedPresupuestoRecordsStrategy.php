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
use App\Application\Configuracion\Queries\ListAllPresupuestosDeletedQuery;
use App\Application\Presupuesto\Contracts\Queries\Executors\PresupuestoQueryExecutorContract;
use App\Domains\Configuracion\Enums\SoftDeleteManagerTypes;
use App\Shared\Domain\Contracts\CollectionContract;

/**
 * Estrategia de listado de presupuestos eliminados.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Infrastructure\Configuracion\Queries\Strategies
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class ListDeletedPresupuestoRecordsStrategy implements ListDeletedDomainRecordsContract
{
    public function __construct(
        private PresupuestoQueryExecutorContract $executor,
        private \App\Application\Configuracion\Contracts\Queries\Enrichers\DeletedDomainRecordsEnricherContract $enricher
    ) {
    }

    public function supports(SoftDeleteManagerTypes $type): bool
    {
        return $type === SoftDeleteManagerTypes::PRESUPUESTOS;
    }

    public function execute(): CollectionContract
    {
        $result = $this->executor->execute(new ListAllPresupuestosDeletedQuery());

        assert($result instanceof CollectionContract);

        return $this->enricher->enrich($result);
    }
}
