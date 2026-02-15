<?php

namespace App\Domains\Cuenta\DTOs;

use App\Domains\Movimiento\Enums\MoneyFlowEnum;
use App\Shared\Abstracts\DTOs\DTO;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;

class UpdateSaldoDTO extends DTO{
    public function __construct(
        public float $saldo_actual
    )
    {
    }

    public function outflow( float $monto){
        $this->saldo_actual -= $monto;
        return $this;
    }
    public function inflow( float $monto){
        $this->saldo_actual += $monto;
        return $this;
    }

    public function moneyFlow(int $tipo_movimiento_id, float $monto, MoneyFlowEnum $moneyFlow = MoneyFlowEnum::APPLY){
         if($moneyFlow === MoneyFlowEnum::APPLY){
            return $tipo_movimiento_id === TipoMovimientoEnum::INGRESO->value ?
            $this->inflow($monto)
            :$this->outflow($monto);
        }
        return $tipo_movimiento_id === TipoMovimientoEnum::INGRESO->value ?
            $this->outflow($monto)
            :$this->inflow($monto);
    }
}