<?php

namespace App\Infrastructure\TipoPresupuesto\Persistence\Repositories\Eloquent;

use App\Domains\TipoPresupuesto\Contracts\Repositories\TipoPresupuestoReadRepositoryContract;
use App\Models\TipoPresupuesto\TipoPresupuesto;
use Illuminate\Database\Eloquent\Collection;

class EloquentTipoPresupuestoReadRepository implements TipoPresupuestoReadRepositoryContract
{
    public function getAll(): Collection
    {
        return TipoPresupuesto::all();
    }
}
