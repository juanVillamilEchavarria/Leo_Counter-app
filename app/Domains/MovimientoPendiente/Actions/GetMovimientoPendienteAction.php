<?php

namespace App\Domains\MovimientoPendiente\Actions;

use App\Models\MovimientoPendiente\MovimientoPendiente;
use App\Domains\MovimientoPendiente\Enums\EstadosMovimientoPendiente;

class GetMovimientoPendienteAction
{

    private array $relations = ['cuenta', 'categoria', 'tipo_movimiento', 'movimiento_fijo'];

    private function getQuery(){
        return MovimientoPendiente::query()->with($this->relations);
    }
    
    public function getAll(){
        return $this->getQuery()->where('estado', EstadosMovimientoPendiente::PENDIENTE->value)->get();
    }

    public function getRecordsCount(){
        return MovimientoPendiente::count();
    }

    public function getWithDetails(MovimientoPendiente $MovimientoPendiente): MovimientoPendiente{
        return $MovimientoPendiente->load($this->relations);
    }
    public function getAvalaibleRecordsCount(){
      return MovimientoPendiente::where('estado', EstadosMovimientoPendiente::PENDIENTE->value)->count();
    }
}
