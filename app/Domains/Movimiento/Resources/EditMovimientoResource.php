<?php

namespace App\Domains\Movimiento\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Domains\ArchivoMovimiento\Resources\ComprobanteResource;
class EditMovimientoResource extends JsonResource
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
            'cuenta_id'=> $this->cuenta_id,
            'categoria_id'=> $this->categoria_id,
            'tipo_movimiento_id'=> $this->tipo_movimiento_id,
            'monto'=>$this->monto,
            'fecha'=>$this->fecha,
            'descripcion'=>$this->descripcion,
            'comprobantes'=> $this->archivoMovimientos ? ComprobanteResource::collection($this->archivoMovimientos) : []
        ];
    }
}
