<?php

namespace App\Domains\MovimientoPendiente\DTOs;

use App\Domains\MovimientoPendiente\DTOs\MovimientoPendienteDTO;

class StoreMovimientoPendienteDTO extends MovimientoPendienteDTO{

    public function toArray() : array: array
    {
        return array_merge(parent::toArray(), []);
    }
}
