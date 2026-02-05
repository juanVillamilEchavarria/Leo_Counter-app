<?php

namespace App\Domains\Presupuesto\DTOs;

use App\Shared\DTOs\DTO;
use Illuminate\Support\Carbon;

abstract class PresupuestoDTO extends DTO {
    public function __construct(
        public int $categoria_id,
        public float $monto,
         public ?Carbon $periodo = null,
        public ?string $descripcion = null,
 
    ){
        $this->periodo = Carbon::now()->firstOfMonth();
    }
}