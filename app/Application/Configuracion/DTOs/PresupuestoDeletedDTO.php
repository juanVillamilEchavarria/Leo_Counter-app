<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Configuracion\DTOs;

/**
 * DTO para representar un presupuesto eliminado con metadata para presentacion.
 *
 * @package App\Application\Configuracion\DTOs
 */
final readonly class PresupuestoDeletedDTO
{
    /**
     * @param string $id
     * @param float $monto
     * @param string|null $descripcion
     * @param string|null $periodo
     * @param string|null $deleted_at
     * @param bool $can_hard_delete
     */
    public function __construct(
        public string $id,
        public float $monto,
        public ?string $descripcion,
        public ?string $periodo,
        public ?string $deleted_at,
        public bool $can_hard_delete
    ){
    }
}
