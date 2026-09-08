<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Application\Auditoria\Contracts\Queries\Executors;

use App\Shared\Domain\Contracts\CollectionContract;

/**
 * Contrato del executor que obtiene las auditorías antiguas (>= 6 meses).
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
interface ListOldAuditoriasQueryExecutorContract
{
    public function execute(): CollectionContract;
}
