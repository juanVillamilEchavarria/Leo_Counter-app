<?php

namespace App\Application\Presupuesto\DTOs;

use App\Shared\Domain\Contracts\CollectionContract;
/**
 * DTO para encapsular las opciones de formularios de presupuesto.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class PresupuestoFormOptionsDTO 
{
    public function __construct(
        public CollectionContract $categorias,
    )
    {
    }
}
