<?php

namespace App\Domains\Profile\Specifications\Domain;

use App\Domains\Profile\DTO\Contracts\ProfileDTOContract;
use App\Domains\Profile\Specifications\Contracts\ProfileDTOSpecificationContract;
use App\Domains\Profile\DTO\UpdateProfileDTO;
use App\Shared\ValueObjects\Email;

/**
 * Especificacion para determinar si el array de datos recibido corresponde a un intento de actualización de información básica del perfil, lo cual se determina por la presencia de las claves 'name' o 'email'.
 */
class ProfileDTOSpecification implements ProfileDTOSpecificationContract{
    public function isSatisfiedBy(array $data): bool{
        return !empty($data['name']) || !empty($data['email']);
    }

    public function buildDTO(array $data): ProfileDTOContract
    {
        $email = isset($data['email']) ? new Email($data['email']) : null;
        return new UpdateProfileDTO(
            name: $data['name'] ,
            email: $email
        );

        
    }
}