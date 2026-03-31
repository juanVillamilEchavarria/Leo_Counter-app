<?php

namespace App\Domains\Profile\Strategies\Domain;
use App\Domains\Profile\Strategies\Contracts\UpdateProfileSectionValidateStrategyContract;
use App\Domains\Profile\DTO\UpdateProfileDTO;
use App\Domains\Profile\DTO\Contracts\ProfileDTOContract;
use App\Models\User;

class NameAndEmailProfileSectionValidateStrategy implements UpdateProfileSectionValidateStrategyContract{
    public function supports(ProfileDTOContract $dto): bool
    {
        return $dto instanceof UpdateProfileDTO;
    }
    public function apply(ProfileDTOContract $dto, User $user): ProfileDTOContract
    {
        // Por ahora no hay reglas especificas, pero aqui se pondra mas adelante cuando se implemente la parte de envio de correos, que el usuario a modificar el correo, no este en la tabla de envio de correos, para evitar que el usuario cambie el correo y luego no pueda recibir el correo de confirmacion para validar su nuevo correo, o para recuperar su contraseña en caso de olvido.
        return $dto;
    }
}