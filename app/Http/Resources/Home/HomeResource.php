<?php

namespace App\Http\Resources\Home;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeResource extends JsonResource
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
            'tendencia'=>[
                    'ingresos_vs_gastos'=> $this->ingresos_vs_gastos
                ]
            ];
    }
}
