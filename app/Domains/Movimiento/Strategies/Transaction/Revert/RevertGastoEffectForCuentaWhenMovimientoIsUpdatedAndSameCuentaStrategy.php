<?php

namespace App\Domains\Movimiento\Strategies\Transaction\Revert;

use App\Application\Movimiento\Contracts\Commands\ModifyMovimientoCommandContract;
use App\Domains\Cuenta\Aggregates\Cuenta;
use App\Domains\Cuenta\ValueObjects\CuentaId;
use App\Domains\Movimiento\Aggregates\Movimiento;
use App\Domains\Movimiento\Contracts\Strategies\RevertTransactionEffectForCuentaStrategyContract;
use App\Domains\Cuenta\Contracts\Repositories\CuentaRepositoryContract;
use App\Application\Movimiento\Commands\UpdateMovimientoCommand;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;


/**
 * Implementacion de la estrategia para revertir el efecto de un gasto cuando un movimiento es actualizado y la cuenta es la misma
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class RevertGastoEffectForCuentaWhenMovimientoIsUpdatedAndSameCuentaStrategy implements RevertTransactionEffectForCuentaStrategyContract
{

    /**
     * @inheritDoc
     */
    public function supports(ModifyMovimientoCommandContract $command, Movimiento $movimiento): bool
    {
        return $command instanceof UpdateMovimientoCommand && $command->tipo_movimiento_id === TipoMovimientoEnum::GASTO->value && $command->cuenta_id === $movimiento->getCuentaId();
    }

    /**
     * @inheritDoc
     */
    public function revertTransactionEffectWhenAMovimientoChanges( ModifyMovimientoCommandContract $command, Movimiento $movimiento, Cuenta $cuenta): Cuenta
    {
        $cuenta = $cuenta->updateSaldoActual($cuenta->getSaldoActual() + $movimiento->getMonto());
        return $cuenta;
    }
}
