<?php

namespace App\Http\Resources\Propietario;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
class PropietarioResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (string) $this->id,
            'nombre' => $this->nombre,
            'apellido'=> $this->apellido,
            'email' => $this->email,
            'telefono'=> $this->telefono,
            'no_cuentas'=> $this->noCuentas,
        ];
    }
}
