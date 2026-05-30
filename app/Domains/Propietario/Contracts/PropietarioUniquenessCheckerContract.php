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
use App\Shared\Domain\ValueObjects\Email;

/**
 * Contrato para validar la unicidad del correo electrónico de un propietario.
 */
interface PropietarioUniquenessCheckerContract
{
    /**
     * Verifica si existe un propietario con el email dado.
     * @param Email $email
     * @param PropietarioId|null $excludeId
     * @return bool
     */
    public function exists(Email $email, ?PropietarioId $excludeId = null): bool;
}
