<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Application\Exportacion\Queries\Handlers;

use App\Application\Exportacion\Contracts\Queries\Executors\ListOldExportacionesQueryExecutorContract;
use App\Application\Exportacion\Queries\ListOldExportacionesQuery;
use App\Shared\Domain\Contracts\CollectionContract;

/**
 * Handler que obtiene las exportaciones antiguas para su limpieza.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
final readonly class ListOldExportacionesHandler
{
    public function __construct(
        private ListOldExportacionesQueryExecutorContract $executor
    ) {}

    public function __invoke(ListOldExportacionesQuery $query): CollectionContract
    {
        return $this->executor->execute();
    }
}
