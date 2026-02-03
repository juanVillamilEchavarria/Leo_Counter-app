<?php
namespace App\Domains\Movimiento\Actions;

use App\Domains\Movimiento\DTOs\StoreMovimientoDTO;
use App\Models\Movimiento\Movimiento;

class StoreMovimientoAction{
    public function store(StoreMovimientoDTO $storeMovimientoDTO) : Movimiento{
        return Movimiento::create($storeMovimientoDTO->toArray());
    }
}