<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Presupuesto\Queries\Handlers;

use App\Application\Presupuesto\Contracts\Queries\Executors\GetPresupuestoRecordsCountQueryExecutorContract;
use App\Application\Presupuesto\Queries\GetCurrentMonthPresupuestosRecordsCountQuery;

/**
 * Clase que ejecuta el query para obtener el número de registros de presupuestos del mes actual.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 * 
 */
final readonly class GetCurrentMonthPresupuestosRecordsCountHandler 
{
    public function __construct(
        private GetPresupuestoRecordsCountQueryExecutorContract $executor
    ) {}

    public function __invoke(GetCurrentMonthPresupuestosRecordsCountQuery $query): int
    {
        return $this->executor->execute();
    }
}
