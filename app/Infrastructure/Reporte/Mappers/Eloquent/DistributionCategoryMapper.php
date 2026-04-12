<?php

namespace App\Infrastructure\Reporte\Mappers\Eloquent;

use App\Domains\Reporte\Collections\DistributionCategoryCollection;
use App\Domains\Reporte\ValueObjects\Category\DistributionCategoryVO;
use Illuminate\Support\Collection;

final class DistributionCategoryMapper
{
    public function map(Collection $rows): DistributionCategoryCollection
    {
        $mapped = $rows->map(static function ($row) {
            return new DistributionCategoryVO(
                (string) $row->categoria,
                (int) $row->cantidad,
                (int) $row->tipo_movimiento_id,
                (float) $row->total
            );
        });

        return DistributionCategoryCollection::make($mapped);
    }
}
