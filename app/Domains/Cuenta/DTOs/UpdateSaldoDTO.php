<?php

namespace App\Domains\Cuenta\DTOs;

use App\Shared\DTOs\DTO;

class UpdateSaldoDTO extends DTO{
    public function __construct(
        public readonly float $saldo_actual
    )
    {
    }

    public function outflow( float $monto){
        return new self($this->saldo_actual - $monto);
    }
    public function inflow( float $monto){
        return new self($this->saldo_actual + $monto);
    }
}