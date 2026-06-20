<?php

/*

@package Leo Counter

@author Juan Villamil juanestebanvillamilechavarria@gmail.com

@license MIT

@copyright 2026 Juan Esteban Villamil Echavarria

@since 1.0.1

@version 1.0.1

*/

namespace App\Application\Transferencia\Queries\Handlers;

use App\Application\Transferencia\Contracts\Queries\Executors\GetTransferenciaRecordsCountQueryExecutorContract;
use App\Application\Transferencia\Queries\GetTransferenciaRecordsCountQuery;

/**
 * Handler encargado de manejar la consulta para obtener el conteo de registros de transferencias.
 * Delegará la ejecución al executor específico inyectado.
 *
 * @package App\Application\Transferencia\Queries\Handlers
 */
final readonly class GetTransferenciaRecordsCountHandler
{
    public function __construct(
        private GetTransferenciaRecordsCountQueryExecutorContract $executor
    ) {}

    /**
     * Maneja el query y retorna el conteo total de transferencias.
     *
     * @param GetTransferenciaRecordsCountQuery $query
     * @return int
     */
    public function __invoke(GetTransferenciaRecordsCountQuery $query): int
    {
        return $this->executor->execute();
    }
}
