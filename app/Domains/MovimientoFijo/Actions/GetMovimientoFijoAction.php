<?php 

namespace App\Domains\MovimientoFijo\Actions;

use App\Models\MovimientoFijo\MovimientoFijo;

class GetMovimientoFijoAction
{
    public function getAll(){
        return MovimientoFijo::with(['cuenta', 'categoria', 'tipo_movimiento', 'frecuencia_movimiento'])->get();
    }
    
    public function getRecordsCount(){
        return MovimientoFijo::count();
    }
}