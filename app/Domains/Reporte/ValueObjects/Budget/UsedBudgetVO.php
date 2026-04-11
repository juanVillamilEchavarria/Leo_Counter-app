<?php

namespace App\Domains\Reporte\ValueObjects\Budget;

final class UsedBudgetVO
{
    public function __construct(
        public float $gastado,
        public float $presupuestado,
        public float $porcentaje_usado,
        public float $disponible
    ) {
    }
}
