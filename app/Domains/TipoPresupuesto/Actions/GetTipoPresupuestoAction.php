<?php

namespace App\Domains\TipoPresupuesto\Actions;
use App\Models\TipoPresupuesto\TipoPresupuesto;
use Illuminate\Database\Eloquent\Collection;

class GetTipoPresupuestoAction{
    public function getAll(): Collection{
        return TipoPresupuesto::all();
    }
}