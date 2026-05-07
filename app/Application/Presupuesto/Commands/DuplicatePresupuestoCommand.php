<?php

namespace App\Application\Presupuesto\Commands;


/**
 * Comando que representa la intención de duplicar un presupuesto existente en el sistema.
 * 
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class DuplicatePresupuestoCommand
{
    public function __construct(
        public string $id
    ) {}
}
