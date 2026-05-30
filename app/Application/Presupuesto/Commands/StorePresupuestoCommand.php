<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Presupuesto\Commands;

/**
 * Comando para almacenar un nuevo presupuesto.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Presupuesto\Commands
 * @since 1.0.0
 * @version 1.0.0 
 */
final readonly class StorePresupuestoCommand
{
    public function __construct(
        public string $categoria_id,
        public float $monto,
        public ?string $descripcion,
        public string $user_id
    ) {}
}
