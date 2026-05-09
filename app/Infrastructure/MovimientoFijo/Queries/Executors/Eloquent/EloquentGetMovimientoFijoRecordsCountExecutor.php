<?php

namespace App\Infrastructure\MovimientoFijo\Queries\Executors\Eloquent;

use App\Application\MovimientoFijo\Contracts\Queries\Executors\GetMovimientoFijoRecordsCountQueryExecutorContract;
use App\Models\MovimientoFijo\MovimientoFijo;

/**
 * Query executor Eloquent para contar registros de MovimientoFijo.
 * Contiene la consulta concreta de infraestructura para el caso de uso de conteo.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Infrastructure\MovimientoFijo\Queries\Executors\Eloquent
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class EloquentGetMovimientoFijoRecordsCountExecutor implements GetMovimientoFijoRecordsCountQueryExecutorContract
{
    public function execute(): int
    {
        return MovimientoFijo::count();
    }
}
