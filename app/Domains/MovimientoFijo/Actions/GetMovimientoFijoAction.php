<?php 

namespace App\Domains\MovimientoFijo\Actions;

use App\Domains\MovimientoFijo\Resources\MovimientoFijoResource;
use App\Models\MovimientoFijo\MovimientoFijo;

class GetMovimientoFijoAction
{
   public function getAll(){
    $movimientos = MovimientoFijo::with(['cuenta', 'categoria', 'tipo_movimiento', 'frecuencia_movimiento'])->get();
       return MovimientoFijoResource::collection($movimientos);
   }
   public function getRecordsCount(){
    return MovimientoFijo::count();
   }
}