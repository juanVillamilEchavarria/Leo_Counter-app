<?php

namespace App\Infrastructure\Movimiento\Queries\Executors\Eloquent;

use App\Application\Movimiento\Contracts\Queries\Executors\GetMovimientoRecordsCountQueryExecutorContract;
use App\Models\Movimiento\Movimiento;
use Carbon\Carbon;

/**
 * Ejecutor Eloquent que obtiene el conteo de movimientos espontáneos (del día).
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class EloquentGetEspontaneoMovimientoRecordsCountQueryExecutor implements GetMovimientoRecordsCountQueryExecutorContract
{
    public function execute(): int
    {
        return Movimiento::query()->where('movimiento_pendiente_id', null)->where('fecha', Carbon::now()->format('Y-m-d'))->count();
    }
}
