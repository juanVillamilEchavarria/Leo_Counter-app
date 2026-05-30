<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\Presupuesto\Queries\Executors\Eloquent;

use App\Application\Presupuesto\Contracts\Queries\Executors\GetPresupuestoRecordsCountQueryExecutorContract;
use App\Models\Presupuesto\Presupuesto;
use Override;

/**
 * Clase que ejecuta el query para obtener el número de registros de presupuestos historicos.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class EloquentGetHistoricPresupuestoRecordsCountQueryExecutor implements GetPresupuestoRecordsCountQueryExecutorContract
{
 #[Override]
 public function execute(): int
 {
    return Presupuesto::count();
 }
}
