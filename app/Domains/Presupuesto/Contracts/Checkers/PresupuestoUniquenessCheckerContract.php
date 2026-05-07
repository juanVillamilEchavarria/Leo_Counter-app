<?php

namespace App\Domains\Presupuesto\Contracts\Checkers;

use App\Domains\Presupuesto\ValueObjects\PresupuestoId;
use DateTimeImmutable;

/**
 * Contracto para el chequeo de unicidad de presupuestos.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
interface PresupuestoUniquenessCheckerContract
{
    public function isUnique(string $categoria_id, DateTimeImmutable|string $periodo, ?PresupuestoId $excludeId = null): bool;
}
