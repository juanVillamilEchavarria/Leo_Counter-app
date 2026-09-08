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

use App\Application\Exportacion\Contracts\Queries\Executors\GetExportacionesRecordsCountQueryExecutorContract;
use App\Application\Exportacion\Queries\GetExportacionesRecordsCountQuery;

/**
 * Handler que obtiene el número total de exportaciones.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
final readonly class GetExportacionesRecordsCountHandler
{
    public function __construct(
        private GetExportacionesRecordsCountQueryExecutorContract $executor,
    ) {}

    public function __invoke(GetExportacionesRecordsCountQuery $query): int
    {
        return $this->executor->execute();
    }
}
