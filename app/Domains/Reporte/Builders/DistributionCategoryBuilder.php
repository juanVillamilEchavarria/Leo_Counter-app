<?php

namespace App\Domains\Reporte\Builders;

use App\Domains\Reporte\DTOs\Category\DistributionCategoryDTO;
use Illuminate\Support\Collection;
class DistributionCategoryBuilder{

    public static function fromQueryResults(Collection $queryResults): Collection
    {
        return $queryResults->map(function ($item) {
            return new DistributionCategoryDTO(
                categoria: $item->categoria,
                cantidad: (int) $item->cantidad,
                tipo_movimiento_id: (int) $item->tipo_movimiento_id,
                total:(float) $item->total
            );
        })->values();
    }
}