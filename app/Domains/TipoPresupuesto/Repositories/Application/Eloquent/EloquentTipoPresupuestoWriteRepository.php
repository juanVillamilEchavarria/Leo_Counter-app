<?php

namespace App\Domains\TipoPresupuesto\Repositories\Application\Eloquent;

use App\Shared\Abstracts\Repositories\EloquentWriteRepository;
use App\Domains\TipoPresupuesto\Repositories\Contracts\TipoPresupuestoWriteRepositoryContract;
use App\Models\TipoPresupuesto\TipoPresupuesto;

class EloquentTipoPresupuestoWriteRepository extends EloquentWriteRepository implements TipoPresupuestoWriteRepositoryContract
{
    public function __construct()
    {
        return parent::__construct(TipoPresupuesto::class);
    }
}
