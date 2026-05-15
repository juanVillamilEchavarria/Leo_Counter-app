<?php

namespace App\Domains\Movimiento\Contracts\Strategies;

use App\Application\Movimiento\Contracts\Commands\WriteMovimientoCommandContract;
use App\Domains\Movimiento\Aggregates\Movimiento;
use App\Domains\Cuenta\Aggregates\Cuenta;

/**
 * Contrato que deben implementar las estrategias que aplican el efecto de una transacción (movimiento) cuando este es Almacenado o actualizado.
 * @example Cuando se registra un movimiento, se debe actualizar el saldo de la cuenta.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
interface ApplyTransactionEffectForCuentaStrategyContract
{
    /**
     * Verifica si la estrategia es compatible con el movimiento, comparando con su tipo movimiento.
     * @param Movimiento $movimiento
     * @return bool
     */
    public function supports (Movimiento $movimiento): bool;

    /**
     * Aplica el efecto de la transacción (movimiento) cuando este es Almacenado o actualizado.
     * @param Movimiento $movimiento - el movimiento ya creado o actualizado
     * @param Cuenta $cuenta
     * @return Cuenta - Cuenta con el efecto de la transacción aplicado.
     */
    public function applyTransactionEffectWhenAMovimientoIsWritten(Movimiento $movimiento, Cuenta $cuenta): Cuenta;

}
