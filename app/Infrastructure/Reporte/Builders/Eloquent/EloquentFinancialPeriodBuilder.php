<?php

namespace App\Infrastructure\Reporte\Builders\Eloquent;

use App\Domains\Reporte\Collections\FinancialPeriodCollection;
use App\Domains\Reporte\ValueObjects\Financial\FinancialPeriodVO;
use Illuminate\Support\Collection as LaravelCollection;

final class EloquentFinancialPeriodBuilder
{
    public static function buildCollection(LaravelCollection $rows): FinancialPeriodCollection
    {
        $items = $rows->map(static function ($row) {
            return new FinancialPeriodVO(
                (string) $row->fecha,
                (float) $row->ingresos,
                (float) $row->gastos,
                (int) $row->count_ingresos,
                (int) $row->count_gastos
            );
        });

        return FinancialPeriodCollection::make($items);
    }
}
