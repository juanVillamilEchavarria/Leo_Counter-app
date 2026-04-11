<?php

namespace App\Domains\TipoMovimiento\Contracts\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface TipoMovimientoReadRepositoryContract {
    public function getAll(): Collection;
}
