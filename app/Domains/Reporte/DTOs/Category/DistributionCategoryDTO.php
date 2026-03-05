<?php

namespace App\Domains\Reporte\DTOs\Category;

use App\Shared\Abstracts\DTOs\DTO;

class DistributionCategoryDTO extends DTO{
    public function __construct(
        public string $categoria,
        public int $cantidad , //cantidad de movimientos asociados
        public float $total, //suma del monto
    )
    {
    }
}