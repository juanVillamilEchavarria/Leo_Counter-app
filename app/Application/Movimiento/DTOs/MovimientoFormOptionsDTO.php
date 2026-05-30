<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Movimiento\DTOs;

use App\Shared\Domain\Contracts\CollectionContract;

/**
 * DTO que encapsula las opciones necesarias por los formularios de movimiento.
 * Agrupa colecciones de categorias, tipos, frecuencias y cuentas.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class MovimientoFormOptionsDTO
{
    public function __construct(
        public CollectionContract $categorias,
        public CollectionContract $tipos_movimientos,
        public CollectionContract $frecuencias_movimientos,
        public CollectionContract $cuentas,
    ){}
}
