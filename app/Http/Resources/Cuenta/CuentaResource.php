<?php

namespace App\Http\Resources\Cuenta;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CuentaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id' => $this->id,
            'nombre' => $this->nombre,
            'saldo_inicial' => $this->saldo_inicial,
            'saldo_actual' => $this->saldo_actual,

            'tipo_cuenta' => $this->tipo_cuenta->tipo_cuenta,
            'propietario' => $this->propietario ? $this->propietario->nombre . ' ' . $this->propietario->apellido : null,
            'notas' => $this->notas,
            'active' => $this->active,
        ];
    }
}
