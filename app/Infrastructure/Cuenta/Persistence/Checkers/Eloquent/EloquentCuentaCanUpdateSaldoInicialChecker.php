<?php

namespace App\Infrastructure\Cuenta\Persistence\Checkers\Eloquent;

use App\Domains\Cuenta\Contracts\CuentaCanUpdateSaldoInicialCheckerContract;
use App\Models\Cuenta\Cuenta;

/**
 * Clase para verificar si se puede actualizar el saldo de una cuenta especifica.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Infrastructure\Cuenta\Persistence\Checkers\Eloquent
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class EloquentCuentaCanUpdateSaldoInicialChecker implements CuentaCanUpdateSaldoInicialCheckerContract{
    public function canUpdateSaldoInicial(int $cuentaId): bool
    {
        return !Cuenta::find($cuentaId)->movimientos()->exists();
    }
}