<?php

namespace App\Infrastructure\Persistence\Repositories\Eloquent\Presupuesto;

use App\Infrastructure\AbstractPersistence\Repositories\Eloquent\EloquentWriteRepository;
use App\Domains\Presupuesto\Contracts\Repositories\PresupuestoWriteRepositoryContract;
use App\Models\Presupuesto\Presupuesto;

class EloquentPresupuestoWriteRepository extends EloquentWriteRepository implements PresupuestoWriteRepositoryContract
{
    public function __construct()
    {
        return parent::__construct(Presupuesto::class);
    }
}
