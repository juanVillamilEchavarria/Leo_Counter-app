<?php

namespace App\Application\Movimiento\Contracts\Queries\Executors;

/**
 * Contrato que debe implementar el query executor encargado de obtener el número de registros de movimientos.
 * Este executor corresponde a un caso de uso específico de conteo de registros, separado del contrato general de consultas de movimientos.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Movimiento\Contracts\Queries\Executors
 * @since 1.0.0
 * @version 1.0.0
 */
interface GetMovimientoRecordsCountQueryExecutorContract
{
    public function execute(): int;
}
