<?php

namespace App\Domains\FrecuenciaMovimiento\Actions;

use App\Models\FrecuenciaMovimiento\FrecuenciaMovimiento;
use Illuminate\Database\Eloquent\Collection;

class GetFrecuenciaMovimientoAction{
    public function getAll(): Collection{
        return FrecuenciaMovimiento::all();
    }
}