<?php

namespace App\Infrastructure\Reporte\Mappers\Eloquent;

use App\Domains\Reporte\Collections\CategoryDistributionCollection;
use App\Domains\Reporte\ValueObjects\Category\CategoryDistributionVO;
use Illuminate\Support\Collection;

final class CategoryDistributionMapper
{
    public function map(Collection $rows): CategoryDistributionCollection
    {
        $mapped = $rows->map(static function ($row) {
            return new CategoryDistributionVO(
                (string) $row->categoria,
                (int) $row->cantidad,
                (int) $row->tipo_movimiento_id,
                (float) $row->total
            );
        });

        return CategoryDistributionCollection::make($mapped);
    }
}
