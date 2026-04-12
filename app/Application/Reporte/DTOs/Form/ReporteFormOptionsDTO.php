<?php

namespace App\Application\Reporte\DTOs\Form;

use App\Shared\Abstracts\DTOs\DTO;
use Illuminate\Support\Collection;
use App\Application\Categoria\DTOs\IngresoAndGastoCategoriaDTO;
class ReporteFormOptionsDTO extends DTO{
    public function __construct(
        public readonly IngresoAndGastoCategoriaDTO $categorias,
        public readonly iterable $cuentas
    )
    {
    }
}