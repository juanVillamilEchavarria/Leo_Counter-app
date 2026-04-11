<?php

namespace App\Application\MovimientoFijo\DTOs;

use App\Application\MovimientoFijo\DTOs\MovimientoFijoDTO;
use Illuminate\Support\Carbon;

class StoreMovimientoFijoDTO extends MovimientoFijoDTO{

    public function toArray() : array
    {
        return array_merge(parent::toArray(), [
            'active'=> true,
            'registrar_automatico'=> false
        ]);
    }
}