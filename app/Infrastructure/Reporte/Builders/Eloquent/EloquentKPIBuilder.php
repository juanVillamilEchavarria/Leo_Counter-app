<?php

namespace App\Infrastructure\Reporte\Builders\Eloquent;

use App\Infrastructure\Reporte\Collections\Laravel\Movimientos\LaravelKPICollection;
use App\Domains\Reporte\ValueObjects\KPI\KPIVO;
use Illuminate\Support\Collection as LaravelCollection;

final class EloquentKPIBuilder
{
    public static function buildCollection(LaravelCollection $rows): LaravelKPICollection
    {
        $items = $rows->map(static function ($row) {
            return new KPIVO(
                (float) $row->total_ingresos,
                (float) $row->total_gastos,
                (int) $row->total_movimientos
            );
        });

        return LaravelKPICollection::make($items);
    }
}
