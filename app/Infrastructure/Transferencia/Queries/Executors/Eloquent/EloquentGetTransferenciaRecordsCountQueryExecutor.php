<?php

/*

@package Leo Counter

@author Juan Villamil juanestebanvillamilechavarria@gmail.com

@license MIT

@copyright 2026 Juan Esteban Villamil Echavarria

@since 1.0.1

@version 1.0.1

*/

namespace App\Infrastructure\Transferencia\Queries\Executors\Eloquent;

use App\Application\Transferencia\Contracts\Queries\Executors\GetTransferenciaRecordsCountQueryExecutorContract;
use App\Models\Transferencia\Transferencia;

/**
 * Ejecutor Eloquent que obtiene el conteo total de transferencias.
 *
 * @package App\Infrastructure\Transferencia\Queries\Executors\Eloquent
 */
final readonly class EloquentGetTransferenciaRecordsCountQueryExecutor implements GetTransferenciaRecordsCountQueryExecutorContract
{
    public function execute(): int
    {
        return Transferencia::query()->count();
    }
}
