<?php

namespace App\Domains\ArchivoMovimiento\DTOs;

use App\Domains\Movimiento\DTOs\StoreMovimientoDTO;
use App\Domains\Movimiento\DTOs\UpdateMovimientoDTO;
use App\Models\Categoria\Categoria;
use App\Models\Movimiento\Movimiento;
use App\Shared\Abstracts\DTOs\DTO;

class ArchivoMovimientoTransferDTO extends DTO{
    public function __construct(
        public array $comprobantes = [],
        public int $movimiento_id
    )
    {
    }

    public static function fromMovimientoAndDTO(StoreMovimientoDTO | UpdateMovimientoDTO $dto, Movimiento $movimiento){
        return new self(
            comprobantes: $dto->comprobantes,
            movimiento_id: $movimiento->id
        );
    }
    public static function fromMovimientoAndArchivos(Movimiento $movimiento, array $comprobantes){
        return new self(
            comprobantes: $comprobantes,
            movimiento_id: $movimiento->id
        );
    }

    public static function fromFileQueryAndCategoriaAndMovimiento($archivos, Categoria $categoria, Movimiento $movimiento){
        return new self(
            comprobantes: $archivos->all(),
            movimiento_id: $movimiento->id
        );
    }
}