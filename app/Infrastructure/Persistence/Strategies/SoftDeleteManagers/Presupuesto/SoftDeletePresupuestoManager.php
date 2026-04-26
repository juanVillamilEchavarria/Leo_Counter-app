<?php

namespace App\Infrastructure\Persistence\Strategies\SoftDeleteManagers\Presupuesto;
use App\Infrastructure\AbstractPersistence\Strategies\SoftDeleteManager;
use App\Domains\Configuracion\Contracts\Strategies\SoftDeleteManagerContract;
use App\Domains\Presupuesto\Contracts\Repositories\PresupuestoReadRepositoryContract;
use App\Domains\Presupuesto\Contracts\Repositories\PresupuestoRepositoryContract;
use App\Domains\Configuracion\Enums\SoftDeleteManagerTypes;
use App\Http\Resources\Configuracion\SoftDeletesManagers\Presupuesto\DeletedPresupuestosResource;

class SoftDeletePresupuestoManager extends SoftDeleteManager implements SoftDeleteManagerContract{
    protected SoftDeleteManagerTypes $domainType = SoftDeleteManagerTypes::PRESUPUESTOS;
    protected ?string $resource = DeletedPresupuestosResource::class;
    public function __construct(
        PresupuestoReadRepositoryContract $readRepository,
        PresupuestoRepositoryContract $writeRepository
    ) {
        parent::__construct($readRepository, $writeRepository);
    }
}
