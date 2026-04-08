<?php

namespace App\Domains\Configuracion\Strategies\Domain\SoftDeleteManagers\Presupuesto;
use App\Domains\Configuracion\Strategies\Abstracts\SoftDeleteManager;
use App\Domains\Configuracion\Strategies\Contracts\SoftDeleteManagerContract;
use App\Domains\Presupuesto\Repositories\Contracts\PresupuestoReadRepositoryContract;
use App\Domains\Presupuesto\Repositories\Contracts\PresupuestoWriteRepositoryContract;
use App\Domains\Configuracion\Enums\SoftDeleteManagerTypes;
use App\Domains\Configuracion\Resources\SoftDeletesManagers\Presupuesto\DeletedPresupuestosResource;

class SoftDeletePresupuestoManager extends SoftDeleteManager implements SoftDeleteManagerContract{
    protected SoftDeleteManagerTypes $domainType = SoftDeleteManagerTypes::PRESUPUESTOS;
    protected ?string $resource = DeletedPresupuestosResource::class;
    public function __construct(
        PresupuestoReadRepositoryContract $readRepository,
        PresupuestoWriteRepositoryContract $writeRepository
    ) {
        parent::__construct($readRepository, $writeRepository);
    }
}
