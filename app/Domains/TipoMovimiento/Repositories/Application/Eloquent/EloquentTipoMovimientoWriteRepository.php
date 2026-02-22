<?php

namespace App\Domains\TipoMovimiento\Repositories\Application\Eloquent;

use App\Shared\Abstracts\Repositories\EloquentWriteRepository;
use App\Domains\TipoMovimiento\Repositories\Contracts\TipoMovimientoWriteRepositoryContract;
use App\Models\TipoMovimiento\TipoMovimiento;

class EloquentTipoMovimientoWriteRepository extends EloquentWriteRepository implements TipoMovimientoWriteRepositoryContract
{
    public function __construct()
    {
        return parent::__construct(TipoMovimiento::class);
    }
}
