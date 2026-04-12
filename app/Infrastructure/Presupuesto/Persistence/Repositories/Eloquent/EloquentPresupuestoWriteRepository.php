<?php

namespace App\Infrastructure\Presupuesto\Persistence\Repositories\Eloquent;

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
