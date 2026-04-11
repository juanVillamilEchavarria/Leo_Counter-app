<?php

namespace App\Domains\ArchivoMovimiento\Contracts\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface ArchivoMovimientoReadRepositoryContract
{
    public function getAll(): Collection;
}
