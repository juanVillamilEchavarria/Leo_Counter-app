<?php

namespace App\Infrastructure\TipoMovimiento\Persistence\Repositories\Eloquent;

use App\Domains\TipoMovimiento\Contracts\Repositories\TipoMovimientoReadRepositoryContract;
use App\Models\TipoMovimiento\TipoMovimiento;

class EloquentTipoMovimientoReadRepository implements TipoMovimientoReadRepositoryContract {

    public function getAll(): \Illuminate\Database\Eloquent\Collection{
        return TipoMovimiento::all();
    }

}
