<?php

namespace App\Domains\Movimiento\Actions;

use App\Models\Movimiento\Movimiento;
use App\Domains\Movimiento\Resources\MovimientoResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GetMovimientoAction{

    private array $relations = ['cuenta', 'categoria', 'movimientoPendiente', 'tipo_movimiento'];

    private function allDetails(){
        return Movimiento::query()->with($this->relations);
    }

    public function getAllWithDetails(){
        return $this->allDetails()->get();
    }
    public function getWithDetails(Movimiento $movimiento){
        $relations = array_merge($this->relations, ['archivoMovimientos']);
        return $movimiento->load($relations);
    }

    public function getRecordsCount(): int{
        return Movimiento::count();
    }
}