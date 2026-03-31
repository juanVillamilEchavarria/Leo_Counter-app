<?php

namespace App\Domains\Profile\Specifications\Domain;

use App\Domains\Profile\DTO\Contracts\ProfileDTOContract;
use App\Domains\Profile\Specifications\Contracts\ProfileDTOSpecificationContract;
use App\Domains\Profile\DTO\UpdatePasswordProfileDTO;
use App\Shared\ValueObjects\Password;

/**
 * Especificacion para determinar si el array de datos recibido corresponde a un intento de actualización de contraseña, lo cual se determina por la presencia de las claves 'password', 'current_password' o 'password_confirmation'.
 */
class PasswordDTOSpecification implements ProfileDTOSpecificationContract{
    public function isSatisfiedBy(array $data): bool{
        return !empty($data['password']) && !empty($data['current_password']);
    }

    public function buildDTO(array $data): ProfileDTOContract
    {
        $password = new Password($data['password']);
        return new UpdatePasswordProfileDTO(
            current_password: $data['current_password'],
            password: $password
        );
    }
}