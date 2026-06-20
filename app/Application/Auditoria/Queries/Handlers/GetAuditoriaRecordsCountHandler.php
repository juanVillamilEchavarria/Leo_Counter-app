<?php

/*

@package Leo Counter

@author Juan Villamil juanestebanvillamilechavarria@gmail.com

@license MIT

@copyright 2026 Juan Esteban Villamil Echavarria

@since 1.0.1

@version 1.0.1

*/

namespace App\Application\Auditoria\Queries\Handlers;

use App\Application\Auditoria\Contracts\Queries\Executors\GetAuditoriaRecordsCountQueryExecutorContract;
use App\Application\Auditoria\Queries\GetAuditoriaRecordsCountQuery;

/**
 * Handler encargado de manejar la consulta para obtener el conteo de registros de auditorías.
 * Delegará la ejecución al executor específico inyectado.
 *
 * @package App\Application\Auditoria\Queries\Handlers
 */
final readonly class GetAuditoriaRecordsCountHandler
{
    public function __construct(
        private GetAuditoriaRecordsCountQueryExecutorContract $executor
    ) {}

    /**
     * Maneja el query y retorna el conteo total de auditorías.
     *
     * @param GetAuditoriaRecordsCountQuery $query
     * @return int
     */
    public function __invoke(GetAuditoriaRecordsCountQuery $query): int
    {
        return $this->executor->execute();
    }
}
