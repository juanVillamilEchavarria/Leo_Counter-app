<?php

namespace App\Domains\Reporte\ValueObjects\Budget;

final readonly class UsedBudgetVO
{
    public function __construct(
        public float $total_presupuesto,
        public float $total_gastos,
        public float $disponible
    ) {}
}