<?php

namespace App\Domains\TipoMovimiento\Actions;

use App\Models\TipoMovimiento\TipoMovimiento;
use Illuminate\Database\Eloquent\Collection;

class GetTipoMovimientoAction
{
    public function getAll(): Collection
    {
        return TipoMovimiento::all();
    }
}