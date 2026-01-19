<?php

namespace App\Domains\MovimientoFijo\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovimientoFijoResource extends JsonResource
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
            'frecuencia_movimiento'=>$this->frecuencia_movimiento ? $this->frecuencia_movimiento->frecuencia_movimiento : null,
            'fecha_proximo'=>$this->fecha_proximo,   
            'monto'=>$this->monto,
            'url_pago'=>$this->url_pago,
            'active'=>$this->active,
            'registrar_automatico'=>$this->registrar_automatico
        ];
    }
}
