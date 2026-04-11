<?php

namespace App\Http\Resources\Reporte;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FullReporteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'KPIs'=> $this->KPIs,
            'tendencia'=> [
                'ingresos_vs_gastos'=> $this->ingresos_vs_gastos,
                'balance_neto_por_fecha'=> $this->balance_neto,
                'presupuesto'=> $this->presupuesto
            ],
            'distribuiciones'=>[
                'por_categoria'=> $this->distribucion_por_categoria

            ],
        ];
    }
}
