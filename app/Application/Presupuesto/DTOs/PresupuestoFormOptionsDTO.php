<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
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
