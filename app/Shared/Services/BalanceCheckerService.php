<?php

namespace App\Shared\Services;
use App\Domains\Cuenta\Actions\GetCuentaAction;
use App\Models\Cuenta\Cuenta;
use App\Shared\Exceptions\InsufficientBalanceException;
class BalanceCheckerService{
    public function __construct(
        private GetCuentaAction $getCuentaAction
    )
    {
    }
     public function canAfford(int $cuenta_id, float $monto): bool{
        $cuenta = $this->getCuentaAction->where('id', $cuenta_id)->firstOrFail();
        return $cuenta->saldo_actual >= $monto;
    }

    public function getCuentaIfCanAfford(int $cuenta_id, float $monto): ?Cuenta{
              $cuenta = $this->getCuentaAction->where('id', $cuenta_id)->firstOrFail();
        if($cuenta->saldo_actual < $monto){
            throw new InsufficientBalanceException;
        }
        return $cuenta;
        
    }
}