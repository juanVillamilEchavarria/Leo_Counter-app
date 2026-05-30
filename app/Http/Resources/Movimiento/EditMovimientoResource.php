<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Http\Resources\Movimiento;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ArchivoMovimiento\ComprobanteResource;
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
            'comprobantes_existing'=> $this->comprobantes_existing ? ComprobanteResource::collection($this->comprobantes_existing) : []
        ];
    }
}
