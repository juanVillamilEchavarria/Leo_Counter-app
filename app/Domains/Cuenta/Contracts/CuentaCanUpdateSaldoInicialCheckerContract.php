<?php

namespace App\Domains\Cuenta\Contracts;

use App\Domains\Cuenta\ValueObjects\CuentaId;

/**
 * Contrato que define la interfaz para verificar si se puede actualizar el saldo inicial de una cuenta especifica.
 * El que se pueda actualizar el saldo inicial de la cuenta, depende de que no tenga movimientos asociados
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Cuenta\Contracts
 * @since 1.0.0
 * @version 1.0.0
 */
interface CuentaCanUpdateSaldoInicialCheckerContract
{
    /**
     * Verifica si se puede actualizar el saldo de una cuenta especifica.
     * @param CuentaId $cuentaId El id de la cuenta a verificar
     * @return bool
     */
    public function canUpdateSaldoInicial(CuentaId $cuentaId): bool;
}