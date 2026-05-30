<?php

namespace App\Application\Reporte\DTOs\Form;

use App\Shared\Domain\Contracts\CollectionContract;
use App\Shared\Application\Contracts\Collections\FormOptions\CategoriaForFormCollectionContract;

final readonly class ReporteFormOptionsDTO {
    public function __construct(
        public  CategoriaForFormCollectionContract $categorias,
        public  CollectionContract $cuentas
    )
    {
    }
}
