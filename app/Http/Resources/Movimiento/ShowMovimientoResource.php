<?php

namespace App\Http\Resources\Movimiento;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Movimiento\MovimientoResource;
use App\Http\Resources\ArchivoMovimiento\ComprobanteResource;

class ShowMovimientoResource extends JsonResource
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
            'cuenta'=> $this->cuenta,
            'categoria'=> $this->categoria ,
            'tipo_movimiento'=> $this->tipo_movimiento,
            'monto'=>$this->monto,
            'fecha'=>$this->fecha,
            'descripcion'=>$this->descripcion,
            'movimiento_pendiente'=> $this->movimiento_pendiente,
            'comprobantes'=> $this->comprobantes ? ComprobanteResource::collection($this->comprobantes) : [],
        ];
    }
}
