<?php

namespace App\Domains\Movimiento\DTOs;

use App\Domains\Movimiento\DTOs\MovimientoDTO;
use Illuminate\Support\Carbon;
use App\Models\MovimientoPendiente\MovimientoPendiente;

class StoreMovimientoDTO extends MovimientoDTO
{
 protected static array $convert = [
    'movimiento_pendiente_id'=> ['id'],
 ];
 protected array $except = [
   'comprobantes'
 ];

 public function toArray()
 {
    return array_merge(parent::toArray(), [
        'fecha'=> Carbon::now()
    ]);
 }
     public static function fromMovimientoPendiente (MovimientoPendiente $movimientoPendiente, array $comprobantes){
      return new self(
         nombre: $movimientoPendiente->nombre,
         cuenta_id: $movimientoPendiente->cuenta_id,
         categoria_id: $movimientoPendiente->categoria_id,
         tipo_movimiento_id: $movimientoPendiente->tipo_movimiento_id,
         monto: $movimientoPendiente->monto,
         movimiento_pendiente_id: $movimientoPendiente->id,
         comprobantes: $comprobantes
      );

    }
}