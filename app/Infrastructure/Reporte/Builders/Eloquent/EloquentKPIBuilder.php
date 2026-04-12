<?php

namespace App\Infrastructure\Reporte\Builders\Eloquent;

use App\Domains\Reporte\Collections\KPICollection;
use App\Domains\Reporte\ValueObjects\KPI\KPIVO;
use Illuminate\Support\Collection as LaravelCollection;

final class EloquentKPIBuilder
{
    public static function buildCollection(LaravelCollection $rows): KPICollection
    {
        $items = $rows->map(static function ($row) {
            return new KPIVO(
                (float) $row->total_ingresos,
                (float) $row->total_gastos,
                (int) $row->total_movimientos
            );
        });

        return KPICollection::make($items);
    }
}
