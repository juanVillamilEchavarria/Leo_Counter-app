<?php

namespace App\Infrastructure\Configuracion\Persistence\Checkers\Eloquent;

use App\Domains\Configuracion\Contracts\Checkers\DomainRecordCanBeDeletedCheckerContract;
use App\Infrastructure\Configuracion\Persistence\Checkers\Eloquent\Abstracts\EloquentDomainRecordCanBeDeletedChecker;
use App\Models\Categoria\Categoria;

/**
 * Verifica si un registro de categoria puede ser eliminado
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Infrastructure\Configuracion\Persistence\Checkers\Eloquent
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class EloquentCategoriaCanBeDeletedChecker extends EloquentDomainRecordCanBeDeletedChecker implements DomainRecordCanBeDeletedCheckerContract
{

    public function __construct()
    {
        parent::__construct(Categoria::class);
    }

    /**
     * @inheritDoc
     */
    protected function relations(): array
    {
        return [
            'movimientos',
            'movimientos_fijos',
            'movimientos_pendientes'
        ];
    }
}
