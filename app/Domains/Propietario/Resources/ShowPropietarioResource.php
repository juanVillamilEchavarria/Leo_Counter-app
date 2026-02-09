<?php

namespace App\Domains\Propietario\Resources;

use Illuminate\Http\Request;
use App\Domains\Propietario\Resources\PropietarioResource;
use App\Domains\Cuenta\Resources\CuentaNombreResource;
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
