<?php

namespace App\Infrastructure\Configuracion\Persistence\Checkers\Eloquent;

use App\Domains\Configuracion\Contracts\Checkers\DomainRecordCanBeDeletedCheckerContract;
use App\Infrastructure\Configuracion\Persistence\Checkers\Eloquent\Abstracts\EloquentDomainRecordCanBeDeletedChecker;
use App\Models\Cuenta\Cuenta;

/**
 * Verifica si un registro de cuenta puede ser eliminado
 */
final readonly class EloquentCuentaCanBeDeletedChecker extends EloquentDomainRecordCanBeDeletedChecker implements DomainRecordCanBeDeletedCheckerContract
{
    public function __construct()
    {
        parent::__construct(Cuenta::class);
    }

    protected function relations(): array
    {
        return [
            'movimientos'
        ];
    }
}
