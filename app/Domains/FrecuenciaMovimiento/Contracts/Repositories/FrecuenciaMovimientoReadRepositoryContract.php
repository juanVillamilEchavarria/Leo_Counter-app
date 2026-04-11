<?php

namespace App\Domains\FrecuenciaMovimiento\Contracts\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface FrecuenciaMovimientoReadRepositoryContract
{
    public function getAll(): Collection;
}
