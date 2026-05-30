<?php

namespace App\Infrastructure\Presupuesto\Queries\Executors\Eloquent;

use App\Application\Presupuesto\Contracts\Queries\Executors\GetPresupuestoRecordsCountQueryExecutorContract;
use App\Models\Presupuesto\Presupuesto;
use App\Shared\Domain\Enums\ComparativeOperators;
use Carbon\Carbon;
use Override;

/**
 * Clase que ejecuta el query para obtener el número de registros de presupuestos del mes actual.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class EloquentGetCurrentMonthPresupuestoRecordsCountQueryExecutor implements GetPresupuestoRecordsCountQueryExecutorContract
{
 #[Override]
 public function execute(): int
 {
    return Presupuesto::query()->where('periodo',ComparativeOperators::EQUALS->value, Carbon::now()->firstOfMonth())->count();
 }
}
