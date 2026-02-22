<?php

namespace App\Domains\FrecuenciaMovimiento\Repositories\Application\Eloquent;

use App\Shared\Abstracts\Repositories\EloquentWriteRepository;
use App\Domains\FrecuenciaMovimiento\Repositories\Contracts\FrecuenciaMovimientoWriteRepositoryContract;
use App\Models\FrecuenciaMovimiento\FrecuenciaMovimiento;

class EloquentFrecuenciaMovimientoWriteRepository extends EloquentWriteRepository implements FrecuenciaMovimientoWriteRepositoryContract
{
    public function __construct()
    {
        return parent::__construct(FrecuenciaMovimiento::class);
    }
}
