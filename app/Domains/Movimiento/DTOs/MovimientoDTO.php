<?php

namespace App\Domains\Movimiento\DTOs;
use App\Shared\DTOs\DTO;

abstract class MovimientoDTO extends DTO{
    public function __construct(
        public string $nombre,
        public int $cuenta_id,
        public int $categoria_id,
        public int $tipo_movimiento_id,
        public float $monto,
        public ?string $descripcion = null,
        public ?int $movimiento_pendiente_id = null,
         public readonly ?array $comprobantes = null
    )
    {
    }
}