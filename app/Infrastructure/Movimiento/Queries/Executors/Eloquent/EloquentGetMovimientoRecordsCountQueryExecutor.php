<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\Movimiento\Queries\Executors\Eloquent;

use App\Application\Movimiento\Contracts\Queries\Executors\GetMovimientoRecordsCountQueryExecutorContract;
use App\Models\Movimiento\Movimiento;

/**
 * Ejecutor Eloquent que obtiene el conteo total de movimientos.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class EloquentGetMovimientoRecordsCountQueryExecutor implements GetMovimientoRecordsCountQueryExecutorContract
{
    public function execute(): int
    {
        return Movimiento::query()->count();
    }
}
