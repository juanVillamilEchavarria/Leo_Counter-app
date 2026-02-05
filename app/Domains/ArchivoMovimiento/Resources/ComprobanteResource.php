<?php

namespace App\Domains\ArchivoMovimiento\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ComprobanteResource extends JsonResource
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
            'nombre' => $this->nombre_original,
            'fecha' => $this->created_at?->format('Y-m-d'),
            'url'=> Storage::disk($this->disk)->exists($this->path) ? Storage::disk($this->disk)->url($this->path  . $this->nombre_guardado) : null
        ];
    }
}
