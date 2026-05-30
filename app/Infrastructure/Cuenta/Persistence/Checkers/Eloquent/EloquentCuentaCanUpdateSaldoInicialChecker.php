<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\Cuenta\Persistence\Checkers\Eloquent;

use App\Domains\Cuenta\Contracts\CuentaCanUpdateSaldoInicialCheckerContract;
use App\Domains\Cuenta\ValueObjects\CuentaId;
use App\Models\Cuenta\Cuenta;

/**
 * Clase para verificar si se puede actualizar el saldo de una cuenta especifica.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Infrastructure\Cuenta\Persistence\Checkers\Eloquent
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class EloquentCuentaCanUpdateSaldoInicialChecker implements CuentaCanUpdateSaldoInicialCheckerContract{
    public function canUpdateSaldoInicial(CuentaId $cuentaId): bool
    {
        $model = Cuenta::find($cuentaId->getValue());
        if (!$model) {
            return false;
        }
        return !$model->movimientos()->exists();
    }
}