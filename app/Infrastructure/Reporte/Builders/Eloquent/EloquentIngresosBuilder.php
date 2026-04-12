<?php

namespace App\Infrastructure\Reporte\Builders\Eloquent;

use App\Domains\Reporte\Collections\IngresosCollection;
use App\Domains\Reporte\ValueObjects\Ingresos\IngresoVO;
use Illuminate\Support\Collection as LaravelCollection;

final class EloquentIngresosBuilder
{
    public static function buildCollection(LaravelCollection $rows): IngresosCollection
    {
        $items = $rows->map(static function ($row) {
            return new IngresoVO(
                (string) $row->fecha,
                (float) $row->monto
            );
        });

        return IngresosCollection::make($items);
    }
}
