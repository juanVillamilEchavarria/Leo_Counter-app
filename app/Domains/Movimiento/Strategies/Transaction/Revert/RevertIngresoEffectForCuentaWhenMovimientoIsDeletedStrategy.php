<?php

namespace App\Domains\Movimiento\Strategies\Transaction\Revert;
use App\Application\Movimiento\Contracts\Commands\ModifyMovimientoCommandContract;
use App\Domains\Cuenta\Aggregates\Cuenta;
use App\Domains\Cuenta\ValueObjects\CuentaId;
use App\Domains\Movimiento\Aggregates\Movimiento;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;
use App\Domains\Movimiento\Contracts\Strategies\RevertTransactionEffectForCuentaStrategyContract;
use App\Application\Movimiento\Commands\DestroyMovimientoCommand;
use App\Domains\Cuenta\Contracts\Repositories\CuentaRepositoryContract;

/**
 * Implementacion de la estrategia para revertir el efecto de un ingreso cuando un movimiento es eliminado
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class RevertIngresoEffectForCuentaWhenMovimientoIsDeletedStrategy implements RevertTransactionEffectForCuentaStrategyContract
{

    /**
     * @inheritDoc
     */
    public function supports(ModifyMovimientoCommandContract $command, Movimiento $movimiento): bool
    {
        return $command instanceof DestroyMovimientoCommand && $movimiento->getTipoMovimientoId() === TipoMovimientoEnum::INGRESO->value;
    }

    /**
     * @inheritDoc
     */
    public function revertTransactionEffectWhenAMovimientoChanges( ModifyMovimientoCommandContract $command,Movimiento $movimiento, Cuenta $cuenta): Cuenta
    {
        $cuenta = $cuenta->updateSaldoActual($cuenta->getSaldoActual() - $movimiento->getMonto());
        return $cuenta;
    }
}
