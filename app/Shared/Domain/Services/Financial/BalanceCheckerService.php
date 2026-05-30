<?php

namespace App\Shared\Domain\Services\Financial;
use App\Domains\Cuenta\Contracts\Repositories\CuentaReadRepositoryContract;
use App\Domains\Movimiento\Contracts\Repositories\MovimientoReadRepositoryContract;
use App\Shared\Domain\ValueObjects\WhereFilterQueryDTO;

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
