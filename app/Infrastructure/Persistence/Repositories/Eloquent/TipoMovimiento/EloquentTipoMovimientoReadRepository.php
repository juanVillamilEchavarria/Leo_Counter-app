<?php

namespace App\Infrastructure\Persistence\Repositories\Eloquent\TipoMovimiento;

use App\Domains\TipoMovimiento\Contracts\Repositories\TipoMovimientoReadRepositoryContract;
use App\Models\TipoMovimiento\TipoMovimiento;

class EloquentTipoMovimientoReadRepository implements TipoMovimientoReadRepositoryContract {

    public function getAll(): \Illuminate\Database\Eloquent\Collection{
        return TipoMovimiento::all();
    }

}
