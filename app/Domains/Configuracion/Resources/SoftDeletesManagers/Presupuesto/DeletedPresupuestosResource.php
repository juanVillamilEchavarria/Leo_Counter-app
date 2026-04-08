<?php

namespace App\Domains\Configuracion\Resources\SoftDeletesManagers\Presupuesto;

use Illuminate\Http\Request;
use App\Domains\Configuracion\Resources\Abstracts\SoftDeleteResource;

/**
 * Resource para los presupuestos eliminados (soft delete) del sistema
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Configuracion\Resources\SoftDeletesManagers\Presupuesto
 * @since 1.0.0
 * @version 1.0.0
 */
class DeletedPresupuestosResource extends SoftDeleteResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=> $this->id,
            'monto'=> $this->monto,
            'descripcion'=> $this->descripcion,
            'periodo'=> $this->periodo,
            'deleted_at'=> $this->deleted_at,
            'can_hard_delete'=> $this->manager->canDelete($this->resource),
        ];
    }
}
