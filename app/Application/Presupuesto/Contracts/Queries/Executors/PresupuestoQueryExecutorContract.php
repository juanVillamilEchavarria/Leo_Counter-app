<?php

namespace App\Application\Presupuesto\Contracts\Queries\Executors;

use App\Application\Presupuesto\Contracts\Queries\ListPresupuestosQueryContract;
use App\Shared\Domain\Contracts\CollectionContract;

/**
 * Contrato que deben implementar todos los ejectutores de consultas de presupuestos que obtengan un listado de presupuestos.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
interface PresupuestoQueryExecutorContract
{
    public function execute(ListPresupuestosQueryContract $query): CollectionContract;
}
