<?php

namespace App\Domains\Profile\Strategies\Domain;

use App\Domains\Auth\Services\Application\AuthService;
use App\Domains\Profile\DTO\Contracts\ProfileDTOContract;
use App\Domains\Profile\DTO\UpdatePasswordProfileDTO;
use App\Domains\Profile\Strategies\Contracts\UpdateProfileSectionValidateStrategyContract;
use App\Models\User;
use App\Domains\Profile\Exceptions\WrongPasswordException;

class PasswordProfileSectionValidateStrategy implements UpdateProfileSectionValidateStrategyContract{
    public function __construct(
        private AuthService $authService
    )
    {
    }
    public function supports(ProfileDTOContract $dto): bool
    {
        return $dto instanceof UpdatePasswordProfileDTO;
    }
    public function apply(ProfileDTOContract $dto, User $user): ProfileDTOContract
    {
        if (!$this->authService->verifyPassword($dto->current_password)) {
                throw new WrongPasswordException('La contraseña actual es incorrecta');
            }
        return $dto;
    }
}