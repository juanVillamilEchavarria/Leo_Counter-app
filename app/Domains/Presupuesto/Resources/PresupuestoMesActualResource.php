<?php

namespace App\Domains\Presupuesto\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Domains\Presupuesto\Resources\PresupuestoResource;
use App\Domains\Presupuesto\Services\Application\PresupuestoService;
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
