<?php

namespace App\Domains\Categoria\DTOs;

use App\Shared\Abstracts\DTOs\DTO;
use Illuminate\Support\Collection;
class IngresoAndGastoCategoriaDTO extends DTO{
    public function __construct(
        public readonly Collection $ingresos,
        public readonly Collection $gastos
    )
    {    }

}