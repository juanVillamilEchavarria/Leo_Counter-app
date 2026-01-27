<?php

namespace App\Domains\Presupuesto\DTOs;

USE App\Shared\DTOs\DTO;

abstract class PresupuestoDTO extends DTO {
    public function __construct(
        public int $categoria_id,
        public int $tipo_presupuesto_id,
        public float $monto,
        public ?string $descripcion = null
    ){}
}