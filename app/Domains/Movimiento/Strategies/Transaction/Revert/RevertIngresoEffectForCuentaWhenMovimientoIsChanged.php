<?php

namespace App\Domains\Movimiento\Strategies\Transaction\Revert;

use App\Domains\Cuenta\Aggregates\Cuenta;
use App\Domains\Movimiento\Aggregates\Movimiento;
use App\Domains\Movimiento\Contracts\Strategies\RevertTransactionEffectForCuentaStrategyContract;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;

/**
 * Implementacion de la estrategia para revertir el efecto de un ingreso cuando un movimiento es actualizado y su cuenta es diferente
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class RevertIngresoEffectForCuentaWhenMovimientoIsChanged implements RevertTransactionEffectForCuentaStrategyContract
{

    /**
     * @inheritDoc
     */
    public function supports(Movimiento $movimiento): bool
    {
        return $movimiento->getTipoMovimientoId() === TipoMovimientoEnum::GASTO;
    }

    /**
     * @inheritDoc
     */
    public function revertTransactionEffectWhenAMovimientoChanges(Movimiento $old_movimiento, Cuenta $old_cuenta): Cuenta
    {
            $oldCuenta = $old_cuenta->updateSaldoActual($old_cuenta->getSaldoActual() - $old_movimiento->getMonto()->getValue());
           return $oldCuenta;
    }
}
