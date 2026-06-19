<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
namespace App\Application\Transferencia\Queries\Handlers;

use App\Application\Transferencia\Queries\ListTransferenciasForTableQuery;
use App\Application\Transferencia\Contracts\Queries\Executors\TransferenciaPaginatedTableQueryExecutorContract;
use App\Shared\Application\DTOs\PaginatedTableResultDTO;

/**
 * Handler encargado de manejar la consulta de transferencias para tabla (server-side).
 * Resuelve el executor especializado en paginación y devuelve el DTO de paginación.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.1
 * @version 1.0.1
 */
final readonly class ListTransferenciasForTableHandler
{
    public function __construct(
        private TransferenciaPaginatedTableQueryExecutorContract $executor
    ) {}

    public function __invoke(ListTransferenciasForTableQuery $query): PaginatedTableResultDTO
    {
        return $this->executor->execute($query);
    }
}
