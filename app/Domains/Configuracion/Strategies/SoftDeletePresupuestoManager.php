<?php

namespace App\Domains\Configuracion\Strategies;
use App\Domains\Configuracion\Contracts\Strategies\SoftDeleteManagerContract;
use App\Domains\Configuracion\Enums\SoftDeleteManagerTypes;
use App\Domains\Configuracion\Strategies\Abstracts\SoftDeleteManager;
use App\Domains\Presupuesto\Contracts\Repositories\PresupuestoRepositoryContract;
use App\Domains\Presupuesto\ValueObjects\PresupuestoId;
use App\Shared\Domain\Contracts\AggregateModelIdContract;

/**
 * Manager de persistencia para registros eliminados de Presupuesto.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Configuracion\Strategies
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class SoftDeletePresupuestoManager extends SoftDeleteManager implements SoftDeleteManagerContract{
    public function __construct(
        PresupuestoRepositoryContract $writeRepository
    ) {
        parent::__construct($writeRepository);
    }

    protected function normalizeId(string $id): AggregateModelIdContract
    {
        return new PresupuestoId($id);
    }

    public function supports(SoftDeleteManagerTypes $domainType): bool
    {
        return $domainType === SoftDeleteManagerTypes::PRESUPUESTOS;
    }

    public function canDelete(AggregateModelIdContract $id): bool
    {
        return true;
    }
}
