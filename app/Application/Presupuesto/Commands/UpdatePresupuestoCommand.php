<?php

namespace App\Application\Presupuesto\Commands;

/**
 * Comando para actualizar un presupuesto existente en el sistema.
 * 
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class UpdatePresupuestoCommand
{
    public function __construct(
        public string $id,
        public string $categoria_id,
        public float $monto,
        public ?string $descripcion,
    ) {}
}
