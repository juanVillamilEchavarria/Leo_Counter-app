<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
namespace App\Application\Auditoria\Queries\Handlers;

use App\Application\Auditoria\Queries\ListAuditoriaForTableQuery;
use App\Application\Auditoria\Contracts\Queries\Executors\AuditoriaPaginatedTableQueryExecutorContract;
use App\Shared\Application\DTOs\PaginatedTableResultDTO;

/**
 * Handler encargado de manejar la consulta para obtener las auditorías filtradas para una tabla (server side).
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 */
final readonly class ListAuditoriaForTableHandler
{
    public function __construct(
        private AuditoriaPaginatedTableQueryExecutorContract $executor
    ){}

    public function __invoke(ListAuditoriaForTableQuery $query): PaginatedTableResultDTO
    {
        return $this->executor->execute($query);
    }
}
