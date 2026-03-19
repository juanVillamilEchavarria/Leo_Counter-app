<?php

namespace App\Domains\MovimientoFijo\DTOs;

use App\Domains\MovimientoFijo\DTOs\MovimientoFijoDTO;
use Illuminate\Support\Carbon;

class StoreMovimientoFijoDTO extends MovimientoFijoDTO{

    public function toArray() : array: array
    {
        return array_merge(parent::toArray(), [
            'active'=> true,
            'registrar_automatico'=> false
        ]);
    }
}