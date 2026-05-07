<?php

namespace App\Application\Presupuesto\Contracts\Queries\Executors;

use App\Application\Presupuesto\Contracts\Queries\GetPresupuestoRecordsCountQueryContract;

/**
 * Contrato que debe implementar el query executor encargado de obtener el número de registros de presupuestos.
 * Este executor corresponde a un caso de uso específico de conteo de registros, separado del contrato general de consultas de presupuestos.
 * 
 * Tanto la clase para obtener los numeros de registros de presupuestos historicos y del mes actual deben implementar este contrato.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Presupuesto\Contracts\Queries\Executors
 * @since 1.0.0
 * @version 1.0.0
 * 
 */
interface GetPresupuestoRecordsCountQueryExecutorContract
{
    public function execute(): int;
}
