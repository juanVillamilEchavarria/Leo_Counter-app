<?php

namespace App\Application\Reporte\DTOs\Form;

use App\Shared\Abstracts\DTOs\DTO;
use Illuminate\Support\Collection;
use App\Application\Categoria\DTOs\IngresoAndGastoCategoriaDTO;
use App\Shared\Domain\Contracts\CollectionContract;
use App\Shared\Application\Contracts\Collections\FormOptions\CategoriaForFormCollectionContract;

class ReporteFormOptionsDTO extends DTO{
    public function __construct(
        public readonly CategoriaForFormCollectionContract $categorias,
        public readonly CollectionContract $cuentas
    )
    {
    }
}