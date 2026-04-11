<?php

namespace App\Infrastructure\Persistence\Repositories\Eloquent\TipoMovimiento;

use App\Infrastructure\AbstractPersistence\Repositories\Eloquent\EloquentWriteRepository;
use App\Domains\TipoMovimiento\Contracts\Repositories\TipoMovimientoWriteRepositoryContract;
use App\Models\TipoMovimiento\TipoMovimiento;

class EloquentTipoMovimientoWriteRepository extends EloquentWriteRepository implements TipoMovimientoWriteRepositoryContract
{
    public function __construct()
    {
        return parent::__construct(TipoMovimiento::class);
    }
}
