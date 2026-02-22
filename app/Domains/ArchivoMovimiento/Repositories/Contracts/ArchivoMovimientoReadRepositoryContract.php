<?php

namespace App\Domains\ArchivoMovimiento\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface ArchivoMovimientoReadRepositoryContract
{
    public function getAll(): Collection;
}
