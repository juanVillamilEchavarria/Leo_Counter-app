<?php

namespace App\Application\Presupuesto\Commands;

/**
 * Comando que representa la intención de eliminar un presupuesto existente en el sistema.
 * 
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 * @package App\Application\Presupuesto\Commands
 */
final readonly class DestroyPresupuestoCommand
{
    public function __construct(
        public string $id
    ) {}
}
