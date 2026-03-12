<?php

namespace App\Domains\Reporte\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReporteFormOptionsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'categorias'=> $this->categorias,
            'cuentas'=> $this->cuentas

        ];
    }
}
