<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
namespace App\Application\Transferencia\Mappers;

use App\Shared\Application\Mappers\TableQueryMapper;
use App\Application\Transferencia\Queries\ListTransferenciasForTableQuery;
use Override;

/**
 * Mapper que convierte una request de tabla a ListTransferenciasForTableQuery.
 * Sigue el mismo patrón que MovimientoForTableMapper.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.1
 * @version 1.0.1
 */
final readonly class TransferenciaForTableMapper extends TableQueryMapper
{
    #[Override]
    protected function query(): string
    {
        return ListTransferenciasForTableQuery::class;
    }
}
