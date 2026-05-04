<?php

namespace App\Infrastructure\Presupuesto\Persistence\Repositories\Eloquent;

use App\Shared\Infrastructure\AbstractPersistence\Repositories\Eloquent\EloquentRepository;
use App\Domains\Presupuesto\Contracts\Repositories\PresupuestoRepositoryContract;
use App\Models\Presupuesto\Presupuesto;

class EloquentPresupuestoRepository extends EloquentRepository implements PresupuestoRepositoryContract
{
    public function __construct()
    {
        return parent::__construct(Presupuesto::class);
    }
}
