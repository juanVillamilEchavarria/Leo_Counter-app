<?php

namespace App\Domains\ArchivoMovimiento\DTOs;

use App\Domains\Movimiento\DTOs\StoreMovimientoDTO;
use App\Models\Movimiento\Movimiento;
use App\Shared\DTOs\DTO;

class ThrowArchivoMovimientoDTO extends DTO{
    public function __construct(
        public array $comprobantes = [],
        public string $categoria = '',
        public string $tipo_movimiento = '',
        public int $movimiento_id
    )
    {
    }

    public static function fromMovimientoAndDTO(StoreMovimientoDTO $dto, Movimiento $movimiento){
        return new self(
            comprobantes: $dto->comprobantes,
            categoria: $movimiento->categoria->nombre,
            tipo_movimiento: $movimiento->tipo_movimiento->tipo_movimiento,
            movimiento_id: $movimiento->id
        );
    }
}