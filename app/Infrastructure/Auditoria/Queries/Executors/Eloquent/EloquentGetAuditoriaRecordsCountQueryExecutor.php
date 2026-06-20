<?php

/*

@package Leo Counter

@author Juan Villamil juanestebanvillamilechavarria@gmail.com

@license MIT

@copyright 2026 Juan Esteban Villamil Echavarria

@since 1.0.1

@version 1.0.1

*/

namespace App\Infrastructure\Auditoria\Queries\Executors\Eloquent;

use App\Application\Auditoria\Contracts\Queries\Executors\GetAuditoriaRecordsCountQueryExecutorContract;
use App\Models\Auditoria\Auditoria;

/**
 * Ejecutor Eloquent que obtiene el conteo total de auditorías.
 *
 * @package App\Infrastructure\Auditoria\Queries\Executors\Eloquent
 */
final readonly class EloquentGetAuditoriaRecordsCountQueryExecutor implements GetAuditoriaRecordsCountQueryExecutorContract
{
    public function execute(): int
    {
        return Auditoria::query()->count();
    }
}
