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
use App\Application\Configuracion\Queries\ListAllCuentasDeletedQuery;
use App\Application\Cuenta\Contracts\Queries\Executors\CuentaQueryExecutorContract;
use App\Domains\Configuracion\Enums\SoftDeleteManagerTypes;
use App\Shared\Domain\Contracts\CollectionContract;

/**
 * Estrategia de listado de cuentas eliminadas.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Infrastructure\Configuracion\Queries\Strategies
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class ListDeletedCuentaRecordsStrategy implements ListDeletedDomainRecordsContract
{
    public function __construct(
        private CuentaQueryExecutorContract $executor,
        private \App\Application\Configuracion\Contracts\Queries\Enrichers\DeletedDomainRecordsEnricherContract $enricher
    ) {
    }

    public function supports(SoftDeleteManagerTypes $type): bool
    {
        return $type === SoftDeleteManagerTypes::CUENTAS;
    }

    public function execute(): CollectionContract
    {
        $result = $this->executor->execute(new ListAllCuentasDeletedQuery());

        assert($result instanceof CollectionContract);

        return $this->enricher->enrich($result);
    }
}
