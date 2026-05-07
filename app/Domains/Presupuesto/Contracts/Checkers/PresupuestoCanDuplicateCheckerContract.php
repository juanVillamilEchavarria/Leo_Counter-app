<?php

namespace App\Domains\Presupuesto\Contracts\Checkers;


/**
 * Contrato que verifica si se puede duplicar un presupuesto.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 * 
 */
interface PresupuestoCanDuplicateCheckerContract
{
    public function canDuplicate(int $categoria_id, string $periodo ): bool;
}
