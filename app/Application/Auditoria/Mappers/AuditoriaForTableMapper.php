<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Auditoria\Mappers;

use App\Shared\Application\Mappers\TableQueryMapper;
use App\Application\Auditoria\Queries\ListAuditoriaForTableQuery;
use Override;

/**
 * Mapper que convierte una request de tabla a ListAuditoriaForTableQuery.
 * Sigue el mismo patrón que los mappers de otros módulos.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 */
final readonly class AuditoriaForTableMapper extends TableQueryMapper
{
    #[Override]
    protected function query(): string
    {
        return ListAuditoriaForTableQuery::class;
    }
}
