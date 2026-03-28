<?php

namespace App\Domains\Presupuesto\DTOs;


use App\Domains\Presupuesto\DTOs\PresupuestoDTO;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
class StorePresupuestoMesActualDTO extends PresupuestoDTO{
    public function toArray() : array
    {
        return array_merge(parent::toArray(),[
            'user_id'=> Auth::user()->id
        ]);
    }
}