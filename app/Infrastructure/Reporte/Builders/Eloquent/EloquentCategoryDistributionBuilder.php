<?php

namespace App\Infrastructure\Reporte\Builders\Eloquent;

use App\Infrastructure\Reporte\Collections\Laravel\Movimientos\LaravelCategoryDistributionCollection;
use App\Domains\Reporte\Contracts\Collections\Movimientos\CategoryDistributionCollectionContract;
use App\Domains\Reporte\ValueObjects\Category\DistributionCategoryVO;
use Illuminate\Support\Collection as LaravelCollection;

final class EloquentCategoryDistributionBuilder
{
    public static function buildCollection(LaravelCollection $rows): LaravelCategoryDistributionCollection
    {
        $items = $rows->map(static function ($row) {
            return new DistributionCategoryVO(
                (string) $row->categoria,
                (int) $row->cantidad,
                (int) $row->tipo_movimiento_id,
                (float) $row->total
            );
        });

        return LaravelCategoryDistributionCollection::make($items);
    }
}
