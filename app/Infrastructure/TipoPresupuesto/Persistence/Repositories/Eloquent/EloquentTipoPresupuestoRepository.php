<?php

namespace App\Infrastructure\TipoPresupuesto\Persistence\Repositories\Eloquent;

use App\Shared\Infrastructure\AbstractPersistence\Repositories\Eloquent\EloquentRepository;
use App\Domains\TipoPresupuesto\Contracts\Repositories\TipoPresupuestoRepositoryContract;
use App\Models\TipoPresupuesto\TipoPresupuesto;

class EloquentTipoPresupuestoRepository extends EloquentRepository implements TipoPresupuestoRepositoryContract
{
    public function __construct()
    {
        return parent::__construct(TipoPresupuesto::class);
    }
}
