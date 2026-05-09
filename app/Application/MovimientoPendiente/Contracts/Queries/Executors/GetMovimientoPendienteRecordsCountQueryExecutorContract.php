<?php

namespace App\Application\MovimientoPendiente\Contracts\Queries\Executors;

/**
 * Contrato para obtener el total de registros de MovimientoPendiente.
 * Aisla el conteo de registros en un query executor especifico de infraestructura.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\MovimientoPendiente\Contracts\Queries\Executors
 * @since 1.0.0
 * @version 1.0.0
 */
interface GetMovimientoPendienteRecordsCountQueryExecutorContract
{
    /**
     * Ejecuta el conteo total de movimientos pendientes disponibles.
     *
     * @return int Total de registros.
     */
    public function execute(): int;
}
