<?php

namespace App\Application\Categoria\DTOs;

use App\Shared\Abstracts\DTOs\DTO;
use App\Shared\Domain\Contracts\CollectionContract;
use Illuminate\Support\Collection;
class IngresoAndGastoCategoriaDTO extends DTO{
    public function __construct(
        public readonly CollectionContract $ingresos,
        public readonly CollectionContract $gastos
    )
    { }

}