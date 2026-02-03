<?php

namespace App\Domains\ArchivoMovimiento\DTOs;

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
}