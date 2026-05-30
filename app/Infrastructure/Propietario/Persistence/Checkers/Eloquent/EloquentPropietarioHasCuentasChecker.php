<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\Propietario\Persistence\Checkers\Eloquent;

use App\Domains\Propietario\Contracts\PropietarioHasCuentasCheckerContract;
use App\Domains\Propietario\ValueObjects\PropietarioId;
use App\Models\Propietario\Propietario;

/**
 * Implementación Eloquent para verificar la existencia de cuentas asociadas a un propietario.
 */
final readonly class EloquentPropietarioHasCuentasChecker implements PropietarioHasCuentasCheckerContract
{
    public function hasCuentas(PropietarioId $propietarioId): bool
    {
        return Propietario::where('id', $propietarioId->getValue())
            ->whereHas('cuentas')
            ->exists();
    }
}
