<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Http\Resources\Configuracion\SoftDeletesManagers\MovimientoPendiente;

use Illuminate\Http\Request;
use App\Http\Resources\Configuracion\Abstracts\SoftDeleteResource;

/**
 * Resource para los movimientos pendientes eliminados (soft delete) del sistema
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Http\Resources\Configuracion\SoftDeletesManagers\MovimientoPendiente
 * @since 1.0.0
 * @version 1.0.0
 */
class DeletedMovimientoPendientesResource extends SoftDeleteResource
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
            'monto'=> $this->monto,
            'fecha_programada'=> $this->fecha_programada,
            'estado'=> $this->estado,
            'deleted_at'=> $this->deleted_at,
            'can_hard_delete'=> $this->can_hard_delete,
        ];
    }
}
