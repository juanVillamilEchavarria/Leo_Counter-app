<?php

namespace App\Infrastructure\Configuracion\Persistence\Checkers\Eloquent;

use App\Domains\Configuracion\Contracts\Checkers\DomainRecordCanBeDeletedCheckerContract;
use App\Infrastructure\Configuracion\Persistence\Checkers\Eloquent\Abstracts\EloquentDomainRecordCanBeDeletedChecker;
use App\Models\MovimientoPendiente\MovimientoPendiente;

final readonly class EloquentMovimientoPendienteCanBeDeletedChecker extends Abstracts\EloquentDomainRecordCanBeDeletedChecker implements DomainRecordCanBeDeletedCheckerContract
{
    public function __construct()
    {
        parent::__construct(MovimientoPendiente::class);
    }

    /**
     * @inheritDoc
     */
    protected function relations(): array
    {
        return [
            'movimientos'
        ];
    }
}
