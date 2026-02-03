<?php

namespace App\Domains\MovimientoPendiente\Actions;

use App\Models\MovimientoPendiente\MovimientoPendiente;
use App\Domains\MovimientoPendiente\DTOs\StoreMovimientoPendienteDTO;

class StoreMovimientoPendienteAction
{
    public function store(StoreMovimientoPendienteDTO $dto): MovimientoPendiente
    {
        return MovimientoPendiente::create($dto->toArray());
    }
}
