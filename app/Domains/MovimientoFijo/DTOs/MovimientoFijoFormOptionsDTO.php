<?php

namespace App\Domains\MovimientoFijo\DTOs;
use Illuminate\Database\Eloquent\Collection;

class MovimientoFijoFormOptionsDTO{
    public function __construct(
        public ?Collection $categorias,
        public ?Collection $tipos_movimientos,
        public ?Collection $frecuencias_movimientos,
        public ?Collection $cuentas
    )
    {
    }

    public function toArray(): array
    {
        return [
            'categorias' => $this->categorias,
            'tipos_movimientos' => $this->tipos_movimientos,
            'frecuencias_movimientos' => $this->frecuencias_movimientos,
            'cuentas' => $this->cuentas
        ];
    }
}