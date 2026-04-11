<?php

namespace App\Application\MovimientoPendiente\DTOs;

use App\Application\MovimientoPendiente\DTOs\MovimientoPendienteDTO;

class StoreMovimientoPendienteDTO extends MovimientoPendienteDTO{

    public function toArray(): array
    {
        return array_merge(parent::toArray(), []);
    }
}
