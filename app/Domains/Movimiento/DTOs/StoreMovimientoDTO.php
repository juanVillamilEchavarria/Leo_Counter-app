<?php

namespace App\Domains\Movimiento\DTOs;

use App\Domains\Movimiento\DTOs\MovimientoDTO;
use Illuminate\Support\Carbon;

class StoreMovimientoDTO extends MovimientoDTO
{
 protected static array $convert = [
    'movimiento_pendiente_id'=> ['id'],
 ];

 public function toArray()
 {
    return array_merge(parent::toArray(), [
        'fecha'=> Carbon::now()
    ]);
 }
}