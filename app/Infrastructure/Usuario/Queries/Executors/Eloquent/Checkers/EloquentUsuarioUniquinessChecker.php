<?php

namespace App\Infrastructure\Usuario\Queries\Executors\Eloquent\Checkers;

use App\Domains\Usuario\Contracts\Checkers\UsuarioUniquinessCheckerContract;
use App\Domains\Usuario\Enums\Roles;
use App\Models\User;
final readonly class EloquentUsuarioUniquinessChecker implements UsuarioUniquinessCheckerContract
{

    /**
     * @inheritDoc
     */
    public function checkIfAdminWasAlreadyCreated(): bool
    {
        return User::where('role', Roles::ADMIN->value)->exists();
    }
}
