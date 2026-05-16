<?php

namespace App\Domains\Movimiento\Strategies\Transaction\Validators;

use App\Domains\Movimiento\Aggregates\Movimiento;
use App\Domains\Movimiento\Contracts\Strategies\TransactionValidatorStrategyContract;
use App\Domains\Movimiento\Exceptions\CannotExecuteMovimientoTransactionException;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;
use App\Shared\Domain\Services\Financial\BalanceCheckerService;

/**
 * Estrategia de validacion para transacciones de tipo gasto.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *  @since 1.0.0
 *  @version 1.0.0
 */
final readonly class GastoValidatorStrategy implements TransactionValidatorStrategyContract {

    public function __construct(
        private BalanceCheckerService $balanceChecker
    )
    {
    }
    public function validate(\App\Domains\Cuenta\Aggregates\Cuenta $cuenta, Movimiento $movimiento): bool
    {
       return $this->balanceChecker->canAfford($cuenta->getSaldoActual(), $movimiento->getMonto()->getValue()) === false ? throw new CannotExecuteMovimientoTransactionException(' saldo insuficiente para hacer un gasto') : true;
    }

    public function supports(Movimiento $movimiento): bool
    {
        return $movimiento->getTipoMovimientoId() === TipoMovimientoEnum::GASTO;
    }
}
