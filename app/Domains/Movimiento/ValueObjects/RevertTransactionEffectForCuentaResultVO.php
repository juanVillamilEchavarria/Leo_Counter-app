<?php

namespace App\Domains\Movimiento\ValueObjects;

use App\Domains\Cuenta\Aggregates\Cuenta;

/**
 * Value Object que representa el resultado de revertir el efecto de una transacción en una cuenta
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class RevertTransactionEffectForCuentaResultVO
{
    /**
     * @param Cuenta|null $old_cuenta - la cuenta vieja del movimiento asociado con los cambios de revertir los efectos de la transaccion, si no tiene una cuenta vieja (no cambio de cuenta en el cambio de movimiento) se devuelve null
     * @param Cuenta $new_cuenta - la cuenta nueva del movimiento asociado con los cambios de revertir los efectos de la transaccion
     */
    public function __construct(
        private ?Cuenta $old_cuenta,
        private Cuenta $new_cuenta
    )
    {
    }
    public function getOldCuenta(): ?Cuenta{
        return $this->old_cuenta;
    }

    public function getNewCuenta(): Cuenta{
        return $this->new_cuenta;
    }

}
