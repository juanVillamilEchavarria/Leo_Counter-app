<?php

namespace App\Http\Resources\Movimiento;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Movimiento\MovimientoResource;
use App\Http\Resources\ArchivoMovimiento\ComprobanteResource;

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
