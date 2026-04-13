<?php

namespace App\Infrastructure\Reporte\Builders\Eloquent;

use App\Infrastructure\Reporte\Collections\Laravel\Movimientos\LaravelMetricPointCollection;
use App\Domains\Reporte\Contracts\Collections\Movimientos\MetricPointCollectionContract;
use App\Domains\Reporte\ValueObjects\Common\MetricPointVO;
use Illuminate\Support\Collection as LaravelCollection;

final class EloquentIngresosBuilder
{
    public static function buildCollection(LaravelCollection $rows): LaravelMetricPointCollection
    {
        $items = $rows->map(static function ($row) {
            return new MetricPointVO(
                (string) $row->fecha,
                (float) $row->monto
            );
        });

        return LaravelMetricPointCollection::make($items);
    }
}
