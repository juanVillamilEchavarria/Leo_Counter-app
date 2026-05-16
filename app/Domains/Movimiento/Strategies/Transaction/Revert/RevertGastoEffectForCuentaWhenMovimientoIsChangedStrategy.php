<?php

namespace App\Domains\Movimiento\Strategies\Transaction\Revert;

use App\Domains\Cuenta\Aggregates\Cuenta;
use App\Domains\Cuenta\ValueObjects\CuentaId;
use App\Domains\Movimiento\Aggregates\Movimiento;
use App\Domains\Movimiento\Contracts\Strategies\RevertTransactionEffectForCuentaStrategyContract;
use App\Domains\Cuenta\Contracts\Repositories\CuentaRepositoryContract;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;
use App\Shared\Domain\ValueObjects\Amount;
use App\Domains\Movimiento\ValueObjects\RevertTransactionEffectForCuentaResultVO;


/**
 * Implementacion de la estrategia para revertir el efecto de un gasto cuando un movimiento es actualizado o eliminado
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class RevertGastoEffectForCuentaWhenMovimientoIsChangedStrategy implements RevertTransactionEffectForCuentaStrategyContract
{

    /**
     * @inheritDoc
     */
    public function supports( Movimiento $movimiento): bool
    {
         return $movimiento->getTipoMovimientoId() === TipoMovimientoEnum::INGRESO;
    }

    /**
     * @inheritDoc
     */
    public function revertTransactionEffectWhenAMovimientoChanges(Movimiento $old_movimiento, Cuenta $old_cuenta): Cuenta
    {
        $oldCuenta = $old_cuenta->updateSaldoActual($old_cuenta->getSaldoActual() + $old_movimiento->getMonto()->getValue());
        return $oldCuenta;
    }
}
