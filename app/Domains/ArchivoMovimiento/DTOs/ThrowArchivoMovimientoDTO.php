<?php

namespace App\Domains\ArchivoMovimiento\DTOs;

use App\Domains\Movimiento\DTOs\StoreMovimientoDTO;
use App\Domains\Movimiento\DTOs\UpdateMovimientoDTO;
use App\Models\Movimiento\Movimiento;
use App\Shared\Abstracts\DTOs\DTO;

class ThrowArchivoMovimientoDTO extends DTO{
    public function __construct(
        public array $comprobantes = [],
        public string $categoria = '',
        public string $tipo_movimiento = '',
        public int $movimiento_id
    )
    {
    }

    public static function fromMovimientoAndDTO(StoreMovimientoDTO | UpdateMovimientoDTO $dto, Movimiento $movimiento){
        return new self(
            comprobantes: $dto->comprobantes,
            categoria: $movimiento->categoria->nombre,
            tipo_movimiento: $movimiento->tipo_movimiento->tipo_movimiento,
            movimiento_id: $movimiento->id
        );
    }
}