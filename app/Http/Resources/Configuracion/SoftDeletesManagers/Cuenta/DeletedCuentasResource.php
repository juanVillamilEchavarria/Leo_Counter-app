<?php

namespace App\Http\Resources\Configuracion\SoftDeletesManagers\Cuenta;

use Illuminate\Http\Request;
use App\Http\Resources\Configuracion\Abstracts\SoftDeleteResource;

/**
 * Resource para las cuentas eliminadas (soft delete) del sistema
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Http\Resources\Configuracion\SoftDeletesManagers\Cuenta
 * @since 1.0.0
 * @version 1.0.0
 */
class DeletedCuentasResource extends SoftDeleteResource
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
            'saldo_inicial'=> $this->saldo_inicial,
            'saldo_actual'=> $this->saldo_actual,
            'deleted_at'=> $this->deleted_at,
            'can_hard_delete'=> $this->manager->canDelete($this->resource),
        ];
    }
}
