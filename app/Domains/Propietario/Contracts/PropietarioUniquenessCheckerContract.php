<?php

namespace App\Domains\Propietario\Contracts;

use App\Shared\Domain\ValueObjects\Email;

/**
 * Contrato para validar la unicidad del correo electrónico de un propietario.
 */
interface PropietarioUniquenessCheckerContract
{
    /**
     * Verifica si existe un propietario con el email dado.
     * @param Email $email
     * @param int|null $excludeId
     * @return bool
     */
    public function exists(Email $email, ?int $excludeId = null): bool;
}
