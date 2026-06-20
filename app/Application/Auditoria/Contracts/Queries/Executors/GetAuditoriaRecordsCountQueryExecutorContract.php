<?php

/*

@package Leo Counter

@author Juan Villamil juanestebanvillamilechavarria@gmail.com

@license MIT

@copyright 2026 Juan Esteban Villamil Echavarria

@since 1.0.1

@version 1.0.1

*/

namespace App\Application\Auditoria\Contracts\Queries\Executors;

/**
 * Contrato que debe implementar el executor encargado de obtener el conteo de registros de auditorías.
 *
 * @package App\Application\Auditoria\Contracts\Queries\Executors
 */
interface GetAuditoriaRecordsCountQueryExecutorContract
{
    /**
     * Ejecuta la consulta para obtener el número total de auditorías.
     * @return int
     */
    public function execute(): int;
}
