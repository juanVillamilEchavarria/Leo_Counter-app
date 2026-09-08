<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Application\Exportacion\Contracts\Queries\Executors;

use App\Shared\Domain\Contracts\CollectionContract;

/**
 * Contrato del executor que obtiene las exportaciones antiguas (>= 6 meses).
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
interface ListOldExportacionesQueryExecutorContract
{
    public function execute(): CollectionContract;
}
