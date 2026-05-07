<?php

namespace App\Application\Presupuesto\Mappers;

use App\Shared\Application\Mappers\TableQueryMapper;
use App\Application\Presupuesto\Queries\ListHistoricPresupuestosForTableQuery;
use Override;

/**
 * Mapper que se encarga de mapear el objeto que llega del controller (request) a ListHistoricPresupuestosForTableFiltersQuery.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Presupuesto\Mappers
 * @since 1.0.0
 * @version 1.0.0
 * @see ListHistoricPresupuestosForTableFiltersQuery
 */
final readonly class ListHistoricPresupuestosForTableMapper extends TableQueryMapper {
    #[Override]
    protected function query(): string
    {
        return ListHistoricPresupuestosForTableQuery::class;
        
    }
}