<?php

namespace App\Domains\Movimiento\Strategies\Transaction\Validators;
use App\Domains\Movimiento\Contracts\Strategies\TransactionValidatorStrategyContract;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;

class IngresoValidatorStrategy implements TransactionValidatorStrategyContract {

    public function validate(\App\Domains\Cuenta\Aggregates\Cuenta $cuenta, float $monto): bool
    {
        return true; // un movimiento de tipo ingreso siempre se permite para cualquier cuenta.
    }

    public function supports(int $tipo_movimiento_id): bool
    {
        return $tipo_movimiento_id === TipoMovimientoEnum::INGRESO->value;
    }
}
