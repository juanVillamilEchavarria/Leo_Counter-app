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

use App\Application\Exportacion\Queries\ExportTableQuery;
use App\Shared\Application\Mappers\TableQueryMapper;
use Override;

final readonly class ExportTableQueryMapper extends TableQueryMapper {
    #[Override]
    protected function query(): string
    {
        return ExportTableQuery::class;
    }
}