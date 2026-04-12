<?php

namespace App\Infrastructure\Reporte\Builders\Eloquent;

use App\Domains\Reporte\Collections\DistributionCategoryCollection;
use App\Domains\Reporte\ValueObjects\Category\DistributionCategoryVO;
use Illuminate\Support\Collection as LaravelCollection;

final class EloquentCategoryDistributionBuilder
{
    public static function buildCollection(LaravelCollection $rows): DistributionCategoryCollection
    {
        $items = $rows->map(static function ($row) {
            return new DistributionCategoryVO(
                (string) $row->categoria,
                (int) $row->cantidad,
                (int) $row->tipo_movimiento_id,
                (float) $row->total
            );
        });

        return DistributionCategoryCollection::make($items);
    }
}
