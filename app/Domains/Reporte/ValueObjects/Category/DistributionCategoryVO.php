<?php

namespace App\Domains\Reporte\ValueObjects\Category;

final class DistributionCategoryVO
{
    public function __construct(
        public string $categoria,
        public int $cantidad,
        public int $tipo_movimiento_id,
        public float $total
    ) {
    }
}
