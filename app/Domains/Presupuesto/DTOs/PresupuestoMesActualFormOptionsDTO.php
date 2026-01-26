<?php

namespace App\Domains\Presupuesto\DTOs;

use App\Shared\DTOs\DTO;
use Illuminate\Database\Eloquent\Collection;
class PresupuestoMesActualFormOptionsDTO extends DTO
{
    public function __construct(
        public ?Collection $categorias
    )
    {
    }
}