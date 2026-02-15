<?php

namespace App\Domains\Movimiento\Strategies\Domain;

use App\Shared\Services\BalanceCheckerService;
use App\Shared\Exceptions\InsufficientBalanceException;
use App\Domains\Movimiento\Exceptions\CannotStoreMovimientoException;
use App\Domains\Movimiento\Contracts\CuentaResolveStrategyContract;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;

class GastoResolveStrategy implements CuentaResolveStrategyContract{

    public function __construct(
        private BalanceCheckerService $balanceChecker
    )
    {
    }
    public function resolve(int $cuenta_id, float $monto){
        try {
            return $this->balanceChecker->getCuentaIfCanAfford($cuenta_id, $monto);
        } catch (InsufficientBalanceException $e) {
            throw new CannotStoreMovimientoException(
                'No se pudo almacenar el movimiento: '. $e->getMessage()
            );
        }
    }

    public function supports(int $tipo_movimiento_id): bool
    {
        return $tipo_movimiento_id === TipoMovimientoEnum::GASTO->value;
    }
}