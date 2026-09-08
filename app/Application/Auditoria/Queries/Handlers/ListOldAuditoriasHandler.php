<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Application\Auditoria\Queries\Handlers;

use App\Application\Auditoria\Contracts\Queries\Executors\ListOldAuditoriasQueryExecutorContract;
use App\Application\Auditoria\Queries\ListOldAuditoriasQuery;
use App\Shared\Domain\Contracts\CollectionContract;

/**
 * Handler que obtiene las auditorías antiguas para su limpieza.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
final readonly class ListOldAuditoriasHandler
{
    public function __construct(
        private ListOldAuditoriasQueryExecutorContract $executor
    ) {}

    public function __invoke(ListOldAuditoriasQuery $query): CollectionContract
    {
        return $this->executor->execute();
    }
}
