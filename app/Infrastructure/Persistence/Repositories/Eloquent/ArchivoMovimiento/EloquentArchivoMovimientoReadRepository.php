<?php

namespace App\Infrastructure\Persistence\Repositories\Eloquent\ArchivoMovimiento;

use App\Domains\ArchivoMovimiento\Contracts\Repositories\ArchivoMovimientoReadRepositoryContract;
use App\Models\ArchivoMovimiento\ArchivoMovimiento;
use Illuminate\Database\Eloquent\Collection;

class EloquentArchivoMovimientoReadRepository implements ArchivoMovimientoReadRepositoryContract
{
    public function getAll(): Collection
    {
        return ArchivoMovimiento::all();
    }
}
