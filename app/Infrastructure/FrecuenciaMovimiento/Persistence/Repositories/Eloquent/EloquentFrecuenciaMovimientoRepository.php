<?php

namespace App\Infrastructure\FrecuenciaMovimiento\Persistence\Repositories\Eloquent;

use App\Infrastructure\AbstractPersistence\Repositories\Eloquent\EloquentRepository;
use App\Domains\FrecuenciaMovimiento\Contracts\Repositories\FrecuenciaMovimientoRepositoryContract;
use App\Models\FrecuenciaMovimiento\FrecuenciaMovimiento;

class EloquentFrecuenciaMovimientoRepository extends EloquentRepository implements FrecuenciaMovimientoRepositoryContract
{
    public function __construct()
    {
        return parent::__construct(FrecuenciaMovimiento::class);
    }
}
