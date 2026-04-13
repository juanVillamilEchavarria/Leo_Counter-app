<?php

namespace App\Infrastructure\Reporte\Mappers\Eloquent;

use App\Domains\Reporte\Collections\IncomeExpensePeriodCollection;
use App\Domains\Reporte\ValueObjects\Financial\IncomeExpensePeriodVO;
use Illuminate\Support\Collection;

final class FinancialPeriodMapper
{
    public function map(Collection $rows): IncomeExpensePeriodCollection
    {
        $mapped = $rows->map(static function ($row) {
            return new IncomeExpensePeriodVO(
                (string) $row->fecha,
                (float) $row->ingresos,
                (float) $row->gastos,
                (int) $row->count_ingresos,
                (int) $row->count_gastos
            );
        });

        return IncomeExpensePeriodCollection::make($mapped);
    }
}
