<?php

namespace App\Domains\Presupuesto\Contracts\Checkers;

use App\Domains\Categoria\ValueObjects\CategoriaId;
use App\Shared\Domain\Contracts\CollectionContract;
use App\Shared\Domain\ValueObjects\Date;

/**
 * Contrato que verifica si se puede duplicar un presupuesto.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
interface PresupuestoCanDuplicateCheckerContract
{
    /**
     * Indica si un presupuesto puede ser duplicado para un periodo dado.
     *
     * @param CategoriaId $categoria_id Identidad de la categoria del presupuesto
     * @param string $periodo Periodo en formato "Y-m" o fecha parseable por Carbon
     * @return bool True si puede duplicarse, false en caso contrario
     */
    public function canDuplicate(CategoriaId $categoria_id, string $periodo ): bool;

    /**
     * Devuelve las categorias que ya tienen un presupuesto en el proximo periodo indicado.
     *
     * @param array $categoriaIds Lista de id de categorias a comprobar
     * @param Date $nextPeriodMonth Periodo objetivo (ej: "2026-06" o cualquier valor parseable por Carbon)
     * @return CollectionContract Lista de id de categorias que ya poseen un presupuesto en el periodo objetivo
     */
    public function findDuplicatedCategories(array $categoriaIds, Date $nextPeriodMonth): CollectionContract;
}
