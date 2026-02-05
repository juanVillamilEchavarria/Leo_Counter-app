<?php

namespace App\Domains\MovimientoPendiente\Actions;

use App\Models\MovimientoPendiente\MovimientoPendiente;
use App\Domains\MovimientoPendiente\Enums\EstadosMovimientoPendiente;

class GetMovimientoPendienteAction
{

    private function getQuery(){
        return MovimientoPendiente::query()->with(['cuenta', 'categoria', 'tipo_movimiento', 'movimiento_fijo']);
    }
    
    public function getAll(){
        return $this->getQuery()->where('estado', EstadosMovimientoPendiente::PENDIENTE->value)->get();
    }

    public function getRecordsCount(){
        return MovimientoPendiente::count();
    }
    public function getAvalaibleRecordsCount(){
      return MovimientoPendiente::where('estado', EstadosMovimientoPendiente::PENDIENTE->value)->count();
    }
}
