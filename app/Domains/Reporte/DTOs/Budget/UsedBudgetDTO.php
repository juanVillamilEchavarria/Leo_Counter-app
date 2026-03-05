<?php

namespace App\Domains\Reporte\DTOs\Budget;

use App\Shared\Abstracts\DTOs\DTO;

class UsedBudgetDTO extends DTO{
    public function __construct(
        public float $gastado,
        public float $presupuestado,
        public float $porcentaje_usado,
        public float $disponible
    )
    {
    }
}