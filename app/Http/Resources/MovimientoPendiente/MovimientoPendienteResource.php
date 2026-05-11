<?php

namespace App\Http\Resources\MovimientoPendiente;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovimientoPendienteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'nombre'=>$this->nombre,
            'descripcion'=>$this->descripcion,
            'tipo_movimiento'=>$this->tipo_movimiento,
            'categoria'=>$this->categoria,
            'cuenta'=>$this->cuenta,
            'movimiento_fijo'=>$this->movimiento_fijo,
            'fecha_programada'=>$this->fecha_programada,
            'monto'=>$this->monto,
            'estado'=>$this->estado,
            'dias_aviso'=>$this->dias_aviso,
            'enough_balance'=>$this->enough_balance
        ];
    }
}
