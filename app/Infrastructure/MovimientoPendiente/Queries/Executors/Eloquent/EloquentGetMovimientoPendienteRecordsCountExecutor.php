<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\MovimientoPendiente\Queries\Executors\Eloquent;

use App\Application\MovimientoPendiente\Contracts\Queries\Executors\GetMovimientoPendienteRecordsCountQueryExecutorContract;
use App\Domains\MovimientoPendiente\Enums\EstadosMovimientoPendiente;
use App\Models\MovimientoPendiente\MovimientoPendiente;

/**
 * Query executor Eloquent para contar registros disponibles de MovimientoPendiente.
 * Contiene la consulta concreta de infraestructura para el caso de uso de conteo,
 * filtrando unicamente los movimientos en estado pendiente.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Infrastructure\MovimientoPendiente\Queries\Executors\Eloquent
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class EloquentGetMovimientoPendienteRecordsCountExecutor implements GetMovimientoPendienteRecordsCountQueryExecutorContract
{
    /**
     * Ejecuta el conteo de movimientos pendientes disponibles.
     * Cuenta unicamente los registros con estado pendiente, replicando
     * la logica del metodo getAvailableRecordsCount del read repository legacy.
     *
     * @return int Total de registros pendientes.
     */
    public function execute(): int
    {
        return MovimientoPendiente::where('estado', EstadosMovimientoPendiente::PENDIENTE->value)->count();
    }
}
