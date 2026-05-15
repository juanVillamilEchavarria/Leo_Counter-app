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
class BalanceCheckerService{
     public function canAfford(float $saldo, float $monto): bool{
        return $saldo >= $monto;
    }

}
