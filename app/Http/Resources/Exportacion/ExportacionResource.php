<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Http\Resources\Exportacion;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Resource que transforma una exportación en su representación JSON para la API.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
final class ExportacionResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_name' => $this->user?->name ?? 'Desconocido',
            'user_email' => $this->user?->email,
            'table' => $this->table,
            'format' => $this->format,
            'records_count' => $this->records_count,
            'filename' => $this->filename,
            'filters' => $this->filters,
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}
