<?php

namespace App\Domains\FrecuenciaMovimiento\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface FrecuenciaMovimientoReadRepositoryContract
{
    public function getAll(): Collection;
}
