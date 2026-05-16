<?php

namespace App\Domains\Movimiento\Strategies\Transaction\Validators;
use App\Domains\Movimiento\Aggregates\Movimiento;
use App\Domains\Movimiento\Contracts\Strategies\TransactionValidatorStrategyContract;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;

/**
 * Estrategia de validacion para transacciones de tipo ingreso.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *  @since 1.0.0
 *  @version 1.0.0
 */
final readonly class IngresoValidatorStrategy implements TransactionValidatorStrategyContract {

    public function validate(\App\Domains\Cuenta\Aggregates\Cuenta $cuenta,Movimiento $movimiento): bool
    {
        return true; // un movimiento de tipo ingreso siempre se permite para cualquier cuenta.
    }

    public function supports(Movimiento $movimiento): bool
    {
        return $movimiento->getTipoMovimientoId() === TipoMovimientoEnum::INGRESO;
    }
}
