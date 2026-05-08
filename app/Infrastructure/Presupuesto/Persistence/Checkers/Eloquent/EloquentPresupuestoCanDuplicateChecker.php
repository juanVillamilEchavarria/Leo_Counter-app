<?php

namespace App\Infrastructure\Presupuesto\Persistence\Checkers\Eloquent;

use App\Domains\Presupuesto\Contracts\Checkers\PresupuestoCanDuplicateCheckerContract;
use App\Domains\Categoria\ValueObjects\CategoriaId;
use App\Models\Presupuesto\Presupuesto;
use Carbon\Carbon;

/**
 * Clase que implementa el chequeo de duplicidad de presupuestos.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class EloquentPresupuestoCanDuplicateChecker implements PresupuestoCanDuplicateCheckerContract
{
    public function canDuplicate(CategoriaId $categoria_id, string $periodo): bool
    {
        $nextMonth = Carbon::parse($periodo)->addMonth()->firstOfMonth();

        return !Presupuesto::query()
            ->where('categoria_id', $categoria_id->getValue())
            ->whereDate('periodo', $nextMonth)
            ->exists();
    }

    /**
     * {@inheritDoc}
     */
    public function findDuplicatedCategories(array $categoriaIds, string $nextPeriodMonth): array
    {
        if (empty($categoriaIds)) {
            return [];
        }


        $nextMonthFirstDay = Carbon::parse($nextPeriodMonth)->firstOfMonth()->toDateString();

        $rows = Presupuesto::query()
            ->whereIn('categoria_id', $categoriaIds)
            ->whereDate('periodo', $nextMonthFirstDay)
            ->pluck('categoria_id')
            ->unique()
            ->values()
            ->toArray();

        return array_map('strval', $rows);
    }
}
