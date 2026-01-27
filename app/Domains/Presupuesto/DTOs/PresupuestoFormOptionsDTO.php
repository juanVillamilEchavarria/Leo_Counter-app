<?php

namespace App\Domains\Presupuesto\DTOs;

use App\Shared\DTOs\DTO;
use Illuminate\Database\Eloquent\Collection;
class PresupuestoFormOptionsDTO extends DTO
{
    public function __construct(
        public ?Collection $categorias,
        public ?Collection $tipo_presupuestos
    )
    {
    }
}