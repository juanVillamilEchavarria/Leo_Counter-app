<?php

namespace App\Domains\Presupuesto\Repositories\Application\Eloquent;

use App\Shared\Abstracts\Repositories\EloquentWriteRepository;
use App\Domains\Presupuesto\Repositories\Contracts\PresupuestoWriteRepositoryContract;
use App\Models\Presupuesto\Presupuesto;

class EloquentPresupuestoWriteRepository extends EloquentWriteRepository implements PresupuestoWriteRepositoryContract
{
    public function __construct()
    {
        return parent::__construct(Presupuesto::class);
    }
}
