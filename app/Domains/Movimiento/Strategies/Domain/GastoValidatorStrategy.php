<?php

namespace App\Domains\Movimiento\Strategies\Domain;

use App\Domains\Movimiento\Contracts\Strategies\TransactionValidatorStrategyContract;
use App\Shared\Domain\Services\Financial\BalanceCheckerService;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;
use App\Domains\Movimiento\Exceptions\CannotExecuteMovimientoTransactionException;

class GastoValidatorStrategy implements TransactionValidatorStrategyContract {

    public function __construct(
        private BalanceCheckerService $balanceChecker
    )
    {
    }
    public function validate(\App\Domains\Cuenta\Aggregates\Cuenta $cuenta, float $monto): bool
    {
       return $this->balanceChecker->canAfford($cuenta->getSaldoActual(), $monto) === false ? throw new CannotExecuteMovimientoTransactionException('No se pudo realizar la transacción, saldo insuficiente para hacer un gasto') : true;
    }

    public function supports(int $tipo_movimiento_id): bool
    {
        return $tipo_movimiento_id === TipoMovimientoEnum::GASTO->value;
    }
}
