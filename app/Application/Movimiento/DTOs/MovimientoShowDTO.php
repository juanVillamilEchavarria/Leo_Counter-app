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
 * DTO de salida para la intención de obtener un movimiento para su visualización con detalles.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class MovimientoShowDTO
{
    public function __construct(
        public string $id,
        public string $nombre,
        public string $cuenta,
        public string $categoria,
        public string $tipo_movimiento,
        public float $monto,
        public string $fecha,
        public ?string $descripcion = null,
        public ?string $movimiento_pendiente = null,
        public  ?CollectionContract $comprobantes = null
    )
    {
    }

}
