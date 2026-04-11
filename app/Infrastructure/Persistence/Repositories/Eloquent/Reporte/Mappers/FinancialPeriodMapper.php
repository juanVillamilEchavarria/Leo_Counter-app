<?php

namespace App\Infrastructure\Persistence\Repositories\Eloquent\Reporte\Mappers;

use App\Domains\Reporte\Collections\FinancialPeriodCollection;
use App\Domains\Reporte\ValueObjects\Financial\FinancialPeriodVO;
use Illuminate\Support\Collection;

final class FinancialPeriodMapper
{
    public function map(Collection $rows): FinancialPeriodCollection
    {
        $mapped = $rows->map(static function ($row) {
            return new FinancialPeriodVO(
                (string) $row->fecha,
                (float) $row->ingresos,
                (float) $row->gastos,
                (int) $row->count_ingresos,
                (int) $row->count_gastos
            );
        });

        return FinancialPeriodCollection::make($mapped);
    }
}
