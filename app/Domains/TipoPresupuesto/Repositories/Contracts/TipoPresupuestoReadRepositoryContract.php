<?php

namespace App\Domains\TipoPresupuesto\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface TipoPresupuestoReadRepositoryContract
{
    public function getAll(): Collection;
}
