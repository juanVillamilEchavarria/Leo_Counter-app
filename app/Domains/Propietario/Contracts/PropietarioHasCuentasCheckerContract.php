<?php

namespace App\Domains\Propietario\Contracts;

use App\Domains\Propietario\ValueObjects\PropietarioId;

/**
 * Contrato para verificar si un propietario tiene cuentas asociadas.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Propietario\Contracts
 * @since 1.0.0
 * @version 1.0.0
 */
interface PropietarioHasCuentasCheckerContract
{
    /**
     * Determina si el propietario tiene cuentas asociadas.
     * @param PropietarioId $propietarioId
     * @return bool
     */
    public function hasCuentas(PropietarioId $propietarioId): bool;
}
