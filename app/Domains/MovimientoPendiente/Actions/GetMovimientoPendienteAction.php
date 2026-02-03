<?php

namespace App\Domains\MovimientoPendiente\Actions;

use App\Domains\MovimientoPendiente\Resources\MovimientoPendienteResource;
use App\Models\MovimientoPendiente\MovimientoPendiente;

class GetMovimientoPendienteAction
{
   public function getAll(){
    $movimientos = MovimientoPendiente::with(['cuenta', 'categoria', 'tipo_movimiento', 'movimiento_fijo'])->get();
       return MovimientoPendienteResource::collection($movimientos);
   }
   public function getRecordsCount(){
    return MovimientoPendiente::count();
   }
}
