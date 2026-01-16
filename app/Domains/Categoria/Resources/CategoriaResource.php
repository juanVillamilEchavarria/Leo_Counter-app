<?php

namespace App\Domains\Categoria\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoriaResource extends JsonResource
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
            'tipo'=>$this->tipoMovimiento ? $this->tipoMovimiento->tipo_movimiento : null,
            'es_fijo'=>$this->es_fijo,
            'descripcion'=>$this->descripcion,
            'is_system'=>$this->is_system
        ];
    }
}
