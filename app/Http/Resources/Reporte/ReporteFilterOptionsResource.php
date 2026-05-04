<?php

namespace App\Http\Resources\Reporte;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReporteFilterOptionsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'categorias'=>[
                'ingresos'=> $this->categorias->ingresos(),
                'gastos'=> $this->categorias->gastos()
            ],
            'cuentas'=> $this->cuentas

        ];
    }
}
