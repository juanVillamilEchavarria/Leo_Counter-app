<?php

namespace App\Domains\Reporte\DTOs\Form;

use App\Shared\Abstracts\DTOs\DTO;
use Illuminate\Support\Collection;
class ReporteFormOptionsDTO extends DTO{
    public function __construct(
        public readonly Collection $categorias,
        public readonly Collection $cuentas
    )
    {
    }
}