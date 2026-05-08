<?php

namespace App\Domains\Presupuesto\Contracts\Checkers;

use App\Domains\Presupuesto\ValueObjects\PresupuestoId;
use App\Domains\Categoria\ValueObjects\CategoriaId;
use DateTimeImmutable;

/**
 * Contracto para el chequeo de unicidad de presupuestos.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
interface PresupuestoUniquenessCheckerContract
{
    /**
     * Indica si para una categoria y periodo no existe ya un presupuesto.
     *
     * @param CategoriaId $categoria_id Identidad de la categoria
     * @param DateTimeImmutable|string $periodo Periodo a comprobar
     * @param PresupuestoId|null $excludeId Id de presupuesto a excluir de la comprobacion
     * @return bool
     */
    public function isUnique(CategoriaId $categoria_id, DateTimeImmutable|string $periodo, ?PresupuestoId $excludeId = null): bool;
}
