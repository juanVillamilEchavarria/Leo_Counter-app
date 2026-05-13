<?php

namespace App\Shared\Domain\Services\Financial;
use App\Domains\Cuenta\Contracts\Repositories\CuentaReadRepositoryContract;
use App\Domains\Movimiento\Contracts\Repositories\MovimientoReadRepositoryContract;
use App\Shared\Enums\ComparativeOperators;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;
use App\Shared\Domain\ValueObjects\WhereFilterQueryDTO;
use App\Domains\Cuenta\Aggregates\Cuenta;
use App\Domains\Movimiento\Aggregates\Movimiento;
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
     public function canAfford(float $saldo, float $monto): bool{
        return $saldo >= $monto;
    }

//    /**
//     * Proceso de verificacion de saldo para una cuenta con un monto nuevo.
//     * Calcula si la cuenta tiene lo suficiente para realizar la transacción.
//     * @param Cuenta $cuenta - cuenta asociada al movimiento
//     * @param float $monto - monto nuevo a almacenar en el movimiento
//     * @param Movimiento|null $movimiento - movimiento existente
//     * @return Cuenta - devuelve la cuenta
//     */
//    public function VerifyCanAffordForCuentaWithANewMonto(Cuenta $cuenta, float $monto, Movimiento | null $movimiento=null): Cuenta{
//              $saldo = $this->calculateAvalaibleBalance($movimiento, $cuenta);
//        if($saldo < $monto){
//            throw new InsufficientBalanceException;
//        }
//        return $cuenta;
//
//    }
//
//        private function calculateAvalaibleBalance(Movimiento | null $movimiento, Cuenta $cuenta): float{
//        if(!$movimiento) return $cuenta->getSaldoActual();
//        if($movimiento->getCuentaId() !== $cuenta->getId()) return $cuenta->getSaldoActual();
//        return $this->revertMovimientoEffect($movimiento, $cuenta->getSaldoActual());
//    }
//
//
//    private function revertMovimientoEffect(Movimiento $movimiento, float $saldo): float{
//        return match($movimiento->getTipoMovimientoId()){
//            TipoMovimientoEnum::GASTO->value => $saldo + $movimiento->getMonto(),
//            TipoMovimientoEnum::INGRESO->value => $saldo - $movimiento->getMonto(),
//            default => $saldo
//        };
//    }
}
