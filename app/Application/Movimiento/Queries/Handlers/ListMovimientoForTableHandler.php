<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Movimiento\Queries\Handlers;

use App\Application\Movimiento\Queries\ListMovimientoForTableQuery;
use App\Application\Movimiento\Contracts\Queries\Executors\MovimientoPaginatedTableQueryExecutorContract;
use App\Shared\Application\DTOs\PaginatedTableResultDTO;

/**
 * Handler encargado de manejar la consulta para obtener los movimientos filtrados para una tabla (server side).
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class ListMovimientoForTableHandler
{
    public function __construct(
        private MovimientoPaginatedTableQueryExecutorContract $executor
    ){}

    public function __invoke(ListMovimientoForTableQuery $query): PaginatedTableResultDTO
    {
        return $this->executor->execute($query);
    }
}
