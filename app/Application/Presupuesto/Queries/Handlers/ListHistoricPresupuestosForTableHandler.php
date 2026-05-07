<?php

namespace App\Application\Presupuesto\Queries\Handlers;

use App\Application\Presupuesto\Contracts\Queries\Executors\PresupuestoPaginatedTableQueryExecutorContract;
use App\Application\Presupuesto\Queries\ListHistoricPresupuestosForTableQuery;
use App\Shared\Application\DTOs\PaginatedTableResultDTO;

/**
 * Handler encargado de manejar la consulta para obtener los presupuestos filtrados para una tabla (server side).
 * Este handler recibe un query de tipo ListPresupuestosForTableQuery y utiliza un executor para ejecutar la consulta y obtener el resultado.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Presupuesto\Queries\Handlers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class ListHistoricPresupuestosForTableHandler
{
    public function __construct(
        private PresupuestoPaginatedTableQueryExecutorContract $executor
    ) {}

    public function __invoke(ListHistoricPresupuestosForTableQuery $query): PaginatedTableResultDTO
    {
        return $this->executor->execute($query);
    }
}
