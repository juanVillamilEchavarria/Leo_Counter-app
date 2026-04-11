<?php

namespace App\Application\Presupuesto\DTOs;

use App\Shared\Abstracts\DTOs\DTO;
use Illuminate\Support\Carbon;

abstract class PresupuestoDTO extends DTO {
    public function __construct(
        public int $categoria_id,
        public float $monto,
         public Carbon | string $periodo = '',
        public ?string $descripcion = null,
 
    ){
        $this->periodo = strlen($this->periodo) ? Carbon::parse($this->periodo) : Carbon::now()->firstOfMonth();
    }
}