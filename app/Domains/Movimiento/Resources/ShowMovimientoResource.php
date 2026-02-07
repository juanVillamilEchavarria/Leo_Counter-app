<?php

namespace App\Domains\Movimiento\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Domains\Movimiento\Resources\MovimientoResource;
use App\Domains\ArchivoMovimiento\Resources\ComprobanteResource;

class ShowMovimientoResource extends MovimientoResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return array_merge(parent::toArray($request), [
            'comprobantes'=> $this->archivoMovimientos ? ComprobanteResource::collection($this->archivoMovimientos) : [],
        ]);
    }
}
