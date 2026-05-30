<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\Configuracion\Persistence\Checkers\Eloquent;

use App\Domains\Configuracion\Contracts\Checkers\DomainRecordCanBeDeletedCheckerContract;
use App\Infrastructure\Configuracion\Persistence\Checkers\Eloquent\Abstracts\EloquentDomainRecordCanBeDeletedChecker;
use App\Models\Presupuesto\Presupuesto;

/**
 * Verifica si un presupuesto puede ser eliminado
 */
final readonly class EloquentPresupuestoCanBeDeletedChecker extends EloquentDomainRecordCanBeDeletedChecker implements DomainRecordCanBeDeletedCheckerContract
{
    public function __construct()
    {
        parent::__construct(Presupuesto::class);
    }

    protected function relations(): array
    {
        return [];
    }
}
