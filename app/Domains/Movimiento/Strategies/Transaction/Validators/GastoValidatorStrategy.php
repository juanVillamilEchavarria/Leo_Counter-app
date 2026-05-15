<?php

namespace App\Domains\Movimiento\Strategies\Transaction\Validators;

use App\Domains\Movimiento\Contracts\Strategies\TransactionValidatorStrategyContract;
use App\Domains\Movimiento\Exceptions\CannotExecuteMovimientoTransactionException;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;
use App\Shared\Domain\Services\Financial\BalanceCheckerService;

class GastoValidatorStrategy implements TransactionValidatorStrategyContract {

    public function __construct(
        private BalanceCheckerService $balanceChecker
    )
    {
    }
    public function validate(\App\Domains\Cuenta\Aggregates\Cuenta $cuenta, float $monto): bool
    {
       return $this->balanceChecker->canAfford($cuenta->getSaldoActual(), $monto) === false ? throw new CannotExecuteMovimientoTransactionException(' saldo insuficiente para hacer un gasto') : true;
    }

    public function supports(int $tipo_movimiento_id): bool
    {
        return $tipo_movimiento_id === TipoMovimientoEnum::GASTO->value;
    }
}
