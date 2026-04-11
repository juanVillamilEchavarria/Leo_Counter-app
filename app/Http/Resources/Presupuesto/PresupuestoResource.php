<?php

namespace App\Http\Resources\Presupuesto;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PresupuestoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'categoria' => $this->categoria ? $this->categoria->nombre : null,
            'monto' => $this->monto,
            'descripcion' => $this->descripcion,
            'periodo' => $this->periodo,
            'user' => $this->user ? $this->user->name .' '. $this->user->apellido : null,
        ];
    }
}
