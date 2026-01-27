<?php

namespace App\Domains\Presupuesto\Resources;

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
            'categoria_id' => $this->categoria_id,
            'categoria' => $this->categoria ? $this->categoria->nombre : null,
            'tipo_presupuesto_id' => $this->tipo_presupuesto_id,
            'tipo_presupuesto' => $this->tipoPresupuesto ? $this->tipoPresupuesto->tipo_presupuesto : null,
            'monto' => $this->monto,
            'descripcion' => $this->descripcion,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_final' => $this->fecha_final,
            'user_id' => $this->user_id,
            'user' => $this->user ? $this->user->name .' '. $this->user->apellido : null,
        ];
    }
}
