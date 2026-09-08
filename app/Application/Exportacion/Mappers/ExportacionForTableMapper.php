<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Application\Exportacion\Mappers;

use App\Application\Exportacion\Queries\ListExportacionesForTableQuery;
use App\Shared\Application\Mappers\TableQueryMapper;
use Override;

/**
 * Mapper que convierte una request de tabla en un ListExportacionesForTableQuery.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
final readonly class ExportacionForTableMapper extends TableQueryMapper
{
    #[Override]
    protected function query(): string
    {
        return ListExportacionesForTableQuery::class;
    }
}
