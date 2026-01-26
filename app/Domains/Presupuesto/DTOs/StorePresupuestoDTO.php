<?php

namespace App\Domains\Presupuesto\DTOs;

use App\Shared\DTOs\DTO;

use Illuminate\Support\Carbon;

class StorePresupuestoDTO extends DTO{
    public function __construct(
        public int $categoria_id,
        public float $monto
    ){}
    public function toArray() : array
    {
        return array_merge(parent::toArray(),[
            'periodo'=> Carbon::now()->format('Y-m'),
            'user_id'=> auth()->user()->id
        ]);
    }
}