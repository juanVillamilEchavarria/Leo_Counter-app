<?php

namespace App\Application\Movimiento\DTOs;

use App\Shared\Domain\Contracts\CollectionContract;

/**
 * DTO que encapsula los datos necesarios de un movimiento para la capa de presentación (edición).
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class MovimientoEditDTO
{
    public function __construct(
        public string $id,
        public string $nombre,
        public string $cuenta_id,
        public string $categoria_id,
        public int $tipo_movimiento_id,
        public float $monto,
        public string $fecha,
        public ?string $descripcion = null,
        public CollectionContract $comprobantes_existing
    ){}
}
