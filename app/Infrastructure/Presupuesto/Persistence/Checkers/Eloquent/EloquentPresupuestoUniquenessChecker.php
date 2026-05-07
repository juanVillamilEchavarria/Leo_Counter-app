<?php

namespace App\Infrastructure\Presupuesto\Persistence\Checkers\Eloquent;

use App\Domains\Presupuesto\Contracts\Checkers\PresupuestoUniquenessCheckerContract;
use App\Models\Presupuesto\Presupuesto;
use App\Domains\Presupuesto\ValueObjects\PresupuestoId;
use DateTimeImmutable;

/**
 * CLase que implementa el chequeo de unicidad de presupuestos.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class EloquentPresupuestoUniquenessChecker implements PresupuestoUniquenessCheckerContract
{
    public function isUnique(string $categoria_id, DateTimeImmutable|string $periodo, ?PresupuestoId $excludeId = null): bool
    {
        $query = Presupuesto::query()
            ->where('categoria_id', $categoria_id)
            ->whereDate('periodo', $periodo);

        if (!is_null($excludeId)) {
            $query->where('id', '!=', $excludeId->getValue());
        }

        return !$query->exists();
    }
}
