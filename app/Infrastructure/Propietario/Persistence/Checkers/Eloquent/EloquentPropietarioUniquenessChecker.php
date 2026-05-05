<?php

namespace App\Infrastructure\Propietario\Persistence\Checkers\Eloquent;

use App\Domains\Propietario\Contracts\PropietarioUniquenessCheckerContract;
use App\Shared\Domain\ValueObjects\Email;
use App\Models\Propietario\Propietario;

final readonly class EloquentPropietarioUniquenessChecker implements PropietarioUniquenessCheckerContract
{
    public function exists(Email $email, ?int $excludeId = null): bool
    {
        $query = Propietario::where('email', (string) $email);

        if ($excludeId !== null) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }
}
