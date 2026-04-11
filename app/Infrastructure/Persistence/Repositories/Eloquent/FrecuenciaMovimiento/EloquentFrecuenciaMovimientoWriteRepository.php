<?php

namespace App\Infrastructure\Persistence\Repositories\Eloquent\FrecuenciaMovimiento;

use App\Infrastructure\AbstractPersistence\Repositories\Eloquent\EloquentWriteRepository;
use App\Domains\FrecuenciaMovimiento\Contracts\Repositories\FrecuenciaMovimientoWriteRepositoryContract;
use App\Models\FrecuenciaMovimiento\FrecuenciaMovimiento;

class EloquentFrecuenciaMovimientoWriteRepository extends EloquentWriteRepository implements FrecuenciaMovimientoWriteRepositoryContract
{
    public function __construct()
    {
        return parent::__construct(FrecuenciaMovimiento::class);
    }
}
