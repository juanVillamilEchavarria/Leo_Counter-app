<?php

namespace App\Shared\Services\Financial;
use App\Domains\Cuenta\Actions\GetCuentaAction;
use App\Domains\Movimiento\Actions\GetMovimientoAction;
use App\Shared\Enums\ComparativeOperators;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;
use App\Shared\DTOs\WhereFilterQueryDTO;
use App\Models\Cuenta\Cuenta;
use App\Models\Movimiento\Movimiento;
use App\Shared\Exceptions\InsufficientBalanceException;
class BalanceCheckerService{
    public function __construct(
        private GetCuentaAction $getCuentaAction,
        private GetMovimientoAction $getMovimientoAction,
    )
    {
    }
     public function canAfford(int $cuenta_id, float $monto, Movimiento | int | null $movimiento=null): bool{
        $cuenta = $this->getCuentaAction->where('id', $cuenta_id)->firstOrFail();
        $saldo = $this->calculateAvalaibleBalance($movimiento, $cuenta->saldo_actual,$cuenta_id);
        return $saldo >= $monto;
    }

    public function getCuentaIfCanAfford(int $cuenta_id, float $monto, Movimiento | int | null $movimiento=null): ?Cuenta{
              $cuenta = $this->getCuentaAction->where('id', $cuenta_id)->firstOrFail();
              $saldo = $this->calculateAvalaibleBalance($movimiento, $cuenta->saldo_actual,$cuenta_id);
        if($saldo < $monto){
            throw new InsufficientBalanceException;
        }
        return $cuenta;
        
    }

        private function calculateAvalaibleBalance(Movimiento |int | null $movimiento, float $saldo, int $cuenta_id): float{
        if(!$movimiento) return $saldo;
        $movimiento = $this->resolveMovimiento($movimiento);
        if($movimiento->cuenta_id !== $cuenta_id) return $saldo;
        return $this->revertMovimientoEffect($movimiento, $saldo);
    }

    private function resolveMovimiento (Movimiento | int $movimiento): Movimiento{
        if($movimiento instanceof Movimiento) return $movimiento;
        $wheres = [
            new WhereFilterQueryDTO('id', ComparativeOperators::EQUALS, $movimiento)
        ];
        return $this->getMovimientoAction->where($wheres)->firstOrFail();
    }

    private function revertMovimientoEffect(Movimiento $movimiento, float $saldo): float{
        return match($movimiento->tipo_movimiento_id){
            TipoMovimientoEnum::GASTO->value => $saldo + $movimiento->monto,
            TipoMovimientoEnum::INGRESO->value => $saldo - $movimiento->monto,
            default => $saldo
        };
    }
}