<?php

namespace App\Domains\ArchivoMovimiento\Repositories\Application\Eloquent;

use App\Domains\ArchivoMovimiento\Repositories\Contracts\ArchivoMovimientoReadRepositoryContract;
use App\Models\ArchivoMovimiento\ArchivoMovimiento;
use Illuminate\Database\Eloquent\Collection;

class EloquentArchivoMovimientoReadRepository implements ArchivoMovimientoReadRepositoryContract
{
    public function getAll(): Collection
    {
        return ArchivoMovimiento::all();
    }
}
