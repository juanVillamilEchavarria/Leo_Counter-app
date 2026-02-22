<?php

namespace App\Domains\FrecuenciaMovimiento\Repositories\Application\Eloquent;

use App\Domains\FrecuenciaMovimiento\Repositories\Contracts\FrecuenciaMovimientoReadRepositoryContract;
use App\Models\FrecuenciaMovimiento\FrecuenciaMovimiento;
use Illuminate\Database\Eloquent\Collection;

class EloquentFrecuenciaMovimientoReadRepository implements FrecuenciaMovimientoReadRepositoryContract
{
    public function getAll(): Collection
    {
        return FrecuenciaMovimiento::all();
    }
}
