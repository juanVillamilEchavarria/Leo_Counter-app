<?php

namespace App\Domains\MovimientoPendiente\Resources;

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
            'tipo_movimiento'=>$this->tipo_movimiento ? $this->tipo_movimiento->tipo_movimiento : null,
            'categoria'=>$this->categoria ? $this->categoria->nombre : null,
            'cuenta'=>$this->cuenta ? $this->cuenta->nombre : null,
            'movimiento_fijo'=>$this->movimiento_fijo ? $this->movimiento_fijo->nombre : null,
            'fecha_programada'=>$this->fecha_programada,   
            'monto'=>$this->monto,
            'url_pago'=>$this->url_pago,
            'estado'=>$this->estado,
            'dias_aviso'=>$this->dias_aviso,
        ];
    }
}
