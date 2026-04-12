<?php

namespace App\Infrastructure\TipoPresupuesto\Persistence\Repositories\Eloquent;

use App\Infrastructure\AbstractPersistence\Repositories\Eloquent\EloquentWriteRepository;
use App\Domains\TipoPresupuesto\Contracts\Repositories\TipoPresupuestoWriteRepositoryContract;
use App\Models\TipoPresupuesto\TipoPresupuesto;

class EloquentTipoPresupuestoWriteRepository extends EloquentWriteRepository implements TipoPresupuestoWriteRepositoryContract
{
    public function __construct()
    {
        return parent::__construct(TipoPresupuesto::class);
    }
}
