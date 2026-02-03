<?php

namespace App\Domains\MovimientoPendiente\Actions;

use App\Domains\MovimientoPendiente\Resources\MovimientoPendienteResource;
use App\Models\MovimientoPendiente\MovimientoPendiente;
use App\Domains\MovimientoPendiente\Enums\EstadosMovimientoPendiente;
class GetMovimientoPendienteAction
{

   private function getQuery(){
      return MovimientoPendiente::query()->with(['cuenta', 'categoria', 'tipo_movimiento', 'movimiento_fijo']);
   }
   public function getAll(){
    $movimientos = $this->getQuery()->where('estado', EstadosMovimientoPendiente::PENDIENTE->value)->get();
       return MovimientoPendienteResource::collection($movimientos);
   }
   public function getRecordsCount(){
    return MovimientoPendiente::count();
   }
}
