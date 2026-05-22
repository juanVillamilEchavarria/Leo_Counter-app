<?php

namespace App\Infrastructure\Notificacion\Persistence\Checkers\Eloquent;

use App\Domains\Notificacion\Contracts\SuscriptorUniquenessCheckerContract;
use App\Models\Notificacion\SuscriptorNotificacion as SuscriptorModel;

final readonly class EloquentSuscriptorUniquenessChecker implements SuscriptorUniquenessCheckerContract
{
    public function exists(string $userId, string $canalId, ?string $excludeId = null): bool
    {
        $query = SuscriptorModel::where('user_id', $userId)
            ->where('canal_notificacion_id', $canalId);

        if ($excludeId !== null) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }
}
