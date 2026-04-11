<?php

namespace App\Http\Resources\Presupuesto;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Presupuesto\PresupuestoResource;
use App\Application\Presupuesto\Services\PresupuestoService;
class PresupuestoMesActualResource extends PresupuestoResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return array_merge(parent::toArray($request), [
            'isDuplicate'=> $this->isDuplicate ?? false,
        ]);
    }
}
