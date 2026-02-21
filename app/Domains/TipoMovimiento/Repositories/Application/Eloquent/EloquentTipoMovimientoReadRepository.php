<?php

namespace App\Domains\TipoMovimiento\Repositories\Application\Eloquent;

use App\Domains\TipoMovimiento\Repositories\Contracts\TipoMovimientoReadRepositoryContract;
use App\Models\TipoMovimiento\TipoMovimiento;

class EloquentTipoMovimientoReadRepository implements TipoMovimientoReadRepositoryContract {

    public function getAll(): \Illuminate\Database\Eloquent\Collection{
        return TipoMovimiento::all();
    }

}
