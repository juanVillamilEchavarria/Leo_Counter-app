<?php

namespace App\Domains\Presupuesto\DTOs;


use App\Domains\Presupuesto\DTOs\PresupuestoDTO;
use Illuminate\Support\Carbon;

class StorePresupuestoMesActualDTO extends PresupuestoDTO{
    public function toArray() : array
    {
        return array_merge(parent::toArray(),[
            'fecha_inicio'=> Carbon::now()->firstOfMonth(),
            'fecha_final'=> Carbon::now()->lastOfMonth(),
            'user_id'=> auth()->user()->id
        ]);
    }
}