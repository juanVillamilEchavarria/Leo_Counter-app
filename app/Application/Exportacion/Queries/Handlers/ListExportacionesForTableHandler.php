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

use App\Application\Exportacion\Contracts\Queries\Executors\ExportacionPaginatedTableQueryExecutorContract;
use App\Application\Exportacion\Queries\ListExportacionesForTableQuery;
use App\Shared\Application\DTOs\PaginatedTableResultDTO;

/**
 * Handler encargado de listar las exportaciones para una tabla server-side.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
final readonly class ListExportacionesForTableHandler
{
    public function __construct(
        private ExportacionPaginatedTableQueryExecutorContract $executor,
    ) {}

    public function __invoke(ListExportacionesForTableQuery $query): PaginatedTableResultDTO
    {
        return $this->executor->execute($query);
    }
}
