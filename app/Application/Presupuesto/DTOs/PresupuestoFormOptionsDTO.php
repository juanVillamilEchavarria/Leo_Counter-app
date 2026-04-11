<?php

namespace App\Application\Presupuesto\DTOs;

use App\Shared\Abstracts\DTOs\DTO;
use Illuminate\Database\Eloquent\Collection;
class PresupuestoFormOptionsDTO extends DTO
{
    public function __construct(
        public ?Collection $categorias,
    )
    {
    }
}
