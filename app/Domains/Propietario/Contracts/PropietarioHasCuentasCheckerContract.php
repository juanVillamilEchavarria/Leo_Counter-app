<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
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
