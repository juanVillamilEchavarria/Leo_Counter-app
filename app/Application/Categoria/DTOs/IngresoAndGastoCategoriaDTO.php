<?php

namespace App\Application\Categoria\DTOs;

use App\Shared\Abstracts\DTOs\DTO;
use Illuminate\Support\Collection;
class IngresoAndGastoCategoriaDTO extends DTO{
    public function __construct(
        public readonly iterable $ingresos,
        public readonly iterable $gastos
    )
    {    }

}