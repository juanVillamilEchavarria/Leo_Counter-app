<?php

namespace App\Infrastructure\Persistence\Repositories\Eloquent\FrecuenciaMovimiento;

use App\Domains\FrecuenciaMovimiento\Contracts\Repositories\FrecuenciaMovimientoReadRepositoryContract;
use App\Models\FrecuenciaMovimiento\FrecuenciaMovimiento;
use Illuminate\Database\Eloquent\Collection;

class EloquentFrecuenciaMovimientoReadRepository implements FrecuenciaMovimientoReadRepositoryContract
{
    public function getAll(): Collection
    {
        return FrecuenciaMovimiento::all();
    }
}
