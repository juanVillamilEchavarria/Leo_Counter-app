<?php

namespace App\Application\Presupuesto\DTOs;


use App\Application\Presupuesto\DTOs\PresupuestoDTO;
use Illuminate\Support\Facades\Auth;
class StorePresupuestoMesActualDTO extends PresupuestoDTO{
    public function toArray() : array
    {
        return array_merge(parent::toArray(),[
            'user_id'=> Auth::user()->id
        ]);
    }
}