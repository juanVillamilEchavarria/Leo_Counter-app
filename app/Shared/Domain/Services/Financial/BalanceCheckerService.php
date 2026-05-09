<?php

namespace App\Shared\Domain\Services\Financial;
use App\Domains\Cuenta\Contracts\Repositories\CuentaReadRepositoryContract;
use App\Domains\Movimiento\Contracts\Repositories\MovimientoReadRepositoryContract;
use App\Shared\Enums\ComparativeOperators;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;
use App\Shared\Domain\ValueObjects\WhereFilterQueryDTO;
use App\Models\Cuenta\Cuenta;
use App\Models\Movimiento\Movimiento;
use App\Shared\Exceptions\InsufficientBalanceException;
use App\Domains\Cuenta\Contracts\Repositories\CuentaRepositoryContract;

/**
 * Servicio que verifica si una cuenta tiene saldo suficiente para realizar una transacción.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Shared\Domain\Services\Financial
 * @version 1.0.0
 * @since 1.0.0
 */
// PENDIENTE LUEGO DE HACER EL REFACTOR AL MODULO DE MOVIMIENTOS
class BalanceCheckerService{
    public function __construct(
        private CuentaReadRepositoryContract $cuentaReadRepository,
        private MovimientoReadRepositoryContract $repository
    )
    {
    }
     public function canAfford(int $cuenta_id, float $monto, Movimiento | int | null $movimiento=null): bool{
        $cuenta = $this->cuentaReadRepository->whereAttr('id', $cuenta_id)->firstOrFail();
        $saldo = $this->calculateAvalaibleBalance($movimiento, $cuenta->saldo_actual,$cuenta_id);
        return $saldo >= $monto;
    }

    public function getCuentaIfCanAfford(int $cuenta_id, float $monto, Movimiento | int | null $movimiento=null): ?Cuenta{
              $cuenta = $this->cuentaReadRepository->whereAttr('id', $cuenta_id)->firstOrFail();
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
        return $this->repository->where($wheres)->firstOrFail();
    }

    private function revertMovimientoEffect(Movimiento $movimiento, float $saldo): float{
        return match($movimiento->tipo_movimiento_id){
            TipoMovimientoEnum::GASTO->value => $saldo + $movimiento->monto,
            TipoMovimientoEnum::INGRESO->value => $saldo - $movimiento->monto,
            default => $saldo
        };
    }
}
