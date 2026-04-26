<?php

namespace App\Infrastructure\TipoMovimiento\Persistence\Repositories\Eloquent;

use App\Infrastructure\AbstractPersistence\Repositories\Eloquent\EloquentRepository;
use App\Domains\TipoMovimiento\Contracts\Repositories\TipoMovimientoRepositoryContract;
use App\Models\TipoMovimiento\TipoMovimiento;

class EloquentTipoMovimientoRepository extends EloquentRepository implements TipoMovimientoRepositoryContract
{
    public function __construct()
    {
        return parent::__construct(TipoMovimiento::class);
    }
}
