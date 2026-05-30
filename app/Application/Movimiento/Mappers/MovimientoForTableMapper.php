<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Movimiento\Mappers;

use App\Shared\Application\Mappers\TableQueryMapper;
use App\Application\Movimiento\Queries\ListMovimientoForTableQuery;
use Override;

/**
 * Mapper que convierte una request de tabla a ListMovimientoForTableQuery.
 * Sigue el mismo patrón que los mappers de Presupuestos.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class MovimientoForTableMapper extends TableQueryMapper
{
    #[Override]
    protected function query(): string
    {
        return ListMovimientoForTableQuery::class;
    }
}
