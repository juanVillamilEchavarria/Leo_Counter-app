<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Http\Resources\MovimientoPendiente;

use App\Http\Resources\MovimientoPendiente\MovimientoPendienteResource;
use Illuminate\Http\Request;
class ShowMovimientoPendienteResource extends MovimientoPendienteResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return array_merge(parent::toArray($request), [
            'automatic'=> (bool) $this->movimiento_fijo? $this->movimiento_fijo->registrar_automatico : null
        ]);
    }
}
