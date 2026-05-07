<?php

namespace App\Infrastructure\Presupuesto\Persistence\Checkers\Eloquent;

use App\Domains\Presupuesto\Contracts\Checkers\PresupuestoCanDuplicateCheckerContract;
use App\Models\Presupuesto\Presupuesto;
use Carbon\Carbon;

/**
 * Clase que implementa el chequeo de duplicidad de presupuestos.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class EloquentPresupuestoCanDuplicateChecker implements PresupuestoCanDuplicateCheckerContract
{
    public function canDuplicate(int $categoria_id, string $periodo): bool
    {
        $nextMonth = Carbon::parse($periodo)->addMonth()->firstOfMonth();

        return !Presupuesto::query()
            ->where('categoria_id', $categoria_id)
            ->whereDate('periodo', $nextMonth)
            ->exists();
    }
}
