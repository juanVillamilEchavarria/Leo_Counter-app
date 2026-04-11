<?php

namespace App\Http\Resources\Propietario;

use Illuminate\Http\Request;
use App\Http\Resources\Propietario\PropietarioResource;
use App\Http\Resources\Cuenta\CuentaNombreResource;
class ShowPropietarioResource extends PropietarioResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return array_merge(parent::toArray($request), [
            'cuentas'=> CuentaNombreResource::collection($this->whenLoaded('cuentas')),
        ]);
    }
}
