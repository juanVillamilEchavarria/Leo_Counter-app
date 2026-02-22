<?php

namespace App\Domains\TipoPresupuesto\Repositories\Application\Eloquent;

use App\Domains\TipoPresupuesto\Repositories\Contracts\TipoPresupuestoReadRepositoryContract;
use App\Models\TipoPresupuesto\TipoPresupuesto;
use Illuminate\Database\Eloquent\Collection;

class EloquentTipoPresupuestoReadRepository implements TipoPresupuestoReadRepositoryContract
{
    public function getAll(): Collection
    {
        return TipoPresupuesto::all();
    }
}
