<?php

namespace App\Domains\Movimiento\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovimientoResource extends JsonResource
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
            'cuenta'=> $this->cuenta ? $this->cuenta->nombre : null,
            'categoria'=> $this->categoria ? $this->categoria->nombre : null,
            'tipo_movimiento'=> $this->tipo_movimiento ? $this->tipo_movimiento->tipo_movimiento : null,
            'monto'=>$this->monto,
            'fecha'=>$this->fecha,
            'descripcion'=>$this->descripcion
        ];
    }
}
