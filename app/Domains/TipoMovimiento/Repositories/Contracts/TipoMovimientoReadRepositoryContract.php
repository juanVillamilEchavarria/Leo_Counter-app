<?php

namespace App\Domains\TipoMovimiento\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface TipoMovimientoReadRepositoryContract {
    public function getAll(): Collection;
}
