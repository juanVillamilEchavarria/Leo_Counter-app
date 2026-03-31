<?php

namespace App\Domains\Profile\Strategies\Contracts;

use App\Domains\Profile\DTO\Contracts\ProfileDTOContract;
use App\Models\User;

/**
 * Interfaz para las validaciones específicas de cada sección del perfil. Cada estrategia implementará esta interfaz y se encargará de validar y aplicar las reglas de negocio correspondientes a su sección.
 */
interface UpdateProfileSectionValidateStrategyContract{
    /**
     * Determina si esta estrategia es aplicable
     */
    public function supports(ProfileDTOContract $dto): bool;
    /**
     * Aplica la validacion y luego retorna de nuevo el DTO con los datos posiblemente modificados o enriquecidos, listo para ser procesado por el servicio de dominio.
     */
    public function apply(ProfileDTOContract $dto, User $user): ProfileDTOContract;
}