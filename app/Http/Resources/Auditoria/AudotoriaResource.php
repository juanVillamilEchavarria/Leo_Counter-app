<?php
/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
namespace App\Http\Resources\Auditoria;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AudotoriaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
             'id' => $this->id,
                'user' => $this->usuario?->name ?? null,
                'auditable_type' => $this->auditable_type,
                'auditable_id' => $this->auditable_id,
                'action' => $this->action,
                'old_values' => $this->old_values ,
                'new_values' => $this->new_values,
                'created_at' => $this->created_at ?? null,
        ];
    }
}
