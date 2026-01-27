<?php

namespace App\Domains\Presupuesto\DTOs;


use App\Domains\Presupuesto\DTOs\PresupuestoDTO;
use Illuminate\Support\Carbon;

class StorePresupuestoPorPeriodoDTO extends PresupuestoDTO{

   public function __construct(
        int $categoria_id,
        int $tipo_presupuesto_id,
        float $monto,
        public string $fecha_inicio,
        public string $fecha_final,
        ?string $descripcion = null,
        
    ) {
        parent::__construct($categoria_id, $tipo_presupuesto_id, $monto, $descripcion);

        $this->fecha_inicio = Carbon::parse($fecha_inicio);
        $this->fecha_final  =  Carbon::parse($fecha_final);
    }
    public function toArray() : array
    {
        return array_merge(parent::toArray(),[
            'user_id'=> auth()->user()->id
        ]);
    }
}