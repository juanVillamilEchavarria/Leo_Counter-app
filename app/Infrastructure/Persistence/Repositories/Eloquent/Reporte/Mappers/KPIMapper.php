<?php

namespace App\Infrastructure\Persistence\Repositories\Eloquent\Reporte\Mappers;

use App\Domains\Reporte\Collections\KPICollection;
use App\Domains\Reporte\ValueObjects\KPI\KPIVO;
use Illuminate\Support\Collection;

final class KPIMapper
{
    public function map(Collection $rows): KPICollection
    {
        $mapped = $rows->map(static function ($row) {
            return new KPIVO(
                (float) $row->total_ingresos,
                (float) $row->total_gastos,
                (int) $row->total_movimientos
            );
        });

        return KPICollection::make($mapped);
    }
}
