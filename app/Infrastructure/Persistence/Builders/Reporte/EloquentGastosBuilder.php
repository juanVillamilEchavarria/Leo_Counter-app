<?php

namespace App\Infrastructure\Persistence\Builders\Reporte;

use App\Domains\Reporte\Collections\GastosCollection;
use App\Domains\Reporte\ValueObjects\Gastos\GastoVO;
use Illuminate\Support\Collection as LaravelCollection;

final class EloquentGastosBuilder
{
    public static function buildCollection(LaravelCollection $rows): GastosCollection
    {
        $items = $rows->map(static function ($row) {
            return new GastoVO(
                (string) $row->fecha,
                (float) $row->monto
            );
        });

        return GastosCollection::make($items);
    }
}
