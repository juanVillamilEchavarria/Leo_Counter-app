<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
namespace App\Http\Resources\Transferencia;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Resource que transforma un modelo Transferencia para las respuestas JSON del API.
 */
class TransferenciaResource extends JsonResource
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
            'cuentaOrigen' => $this->cuentaOrigen ? $this->cuentaOrigen->nombre : null,
            'cuentaDestino' => $this->cuentaDestino ? $this->cuentaDestino->nombre : null,
            'monto' => $this->monto,
            'fecha' => $this->fecha,
            'descripcion' => $this->descripcion,
        ];
    }
}
