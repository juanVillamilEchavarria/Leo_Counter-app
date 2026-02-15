<?php

namespace App\Domains\MovimientoFijo\DTOs;
use Illuminate\Database\Eloquent\Collection;
use App\Shared\Abstracts\DTOs\DTO;
class MovimientoFijoFormOptionsDTO extends DTO{
    public function __construct(
        public ?Collection $categorias,
        public ?Collection $tipos_movimientos,
        public ?Collection $frecuencias_movimientos,
        public ?Collection $cuentas
    )
    {
    }

}