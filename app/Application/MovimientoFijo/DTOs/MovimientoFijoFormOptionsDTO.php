<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\MovimientoFijo\DTOs;

use App\Shared\Domain\Contracts\CollectionContract;

/**
 * DTO que encapsula las opciones requeridas por los formularios de MovimientoFijo.
 * Agrupa colecciones de categorias, tipos de movimiento, frecuencias y cuentas provenientes
 * de query executors compartidos de la capa de aplicacion.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\MovimientoFijo\DTOs
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class MovimientoFijoFormOptionsDTO
{
    public function __construct(
        public CollectionContract $categorias,
        public CollectionContract $tipos_movimientos,
        public CollectionContract $frecuencias_movimientos,
        public CollectionContract $cuentas,
    )
    {
    }
}
