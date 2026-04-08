<?php

namespace App\Domains\Configuracion\Resources\SoftDeletesManagers\Categoria;

use Illuminate\Http\Request;
use App\Domains\Configuracion\Resources\Abstracts\SoftDeleteResource;

/**
 * Resource para las categorías eliminadas (soft delete) del sistema
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Configuracion\Resources\SoftDeletesManagers\Categoria
 * @since 1.0.0
 * @version 1.0.0
 */
class DeletedCategoriaResource extends SoftDeleteResource
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
            'nombre'=> $this->nombre,
            'descripcion'=> $this->descripcion,
            'es_fijo'=> $this->es_fijo,
            'deleted_at'=> $this->deleted_at,
            'can_hard_delete'=> $this->manager->canDelete($this->resource),
        ];
    }
}
