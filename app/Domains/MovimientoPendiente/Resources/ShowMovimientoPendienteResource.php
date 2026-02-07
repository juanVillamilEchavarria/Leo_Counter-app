<?php

namespace App\Domains\MovimientoPendiente\Resources;

use App\Domains\MovimientoPendiente\Resources\MovimientoPendienteResource;
use Illuminate\Http\Request;
class ShowMovimientoPendienteResource extends MovimientoPendienteResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return array_merge(parent::toArray($request), [
            'automatic'=> (bool) $this->movimiento_fijo? $this->movimiento_fijo->registrar_automatico : null
        ]);
    }
}
