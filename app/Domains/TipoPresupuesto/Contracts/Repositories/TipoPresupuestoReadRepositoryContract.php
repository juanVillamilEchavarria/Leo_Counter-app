<?php

namespace App\Domains\TipoPresupuesto\Contracts\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface TipoPresupuestoReadRepositoryContract
{
    public function getAll(): Collection;
}
