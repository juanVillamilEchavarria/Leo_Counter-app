<?php

namespace App\Infrastructure\Reporte\Builders\Eloquent;

use App\Domains\Reporte\ValueObjects\Budget\UsedBudgetVO;

final class EloquentUsedBudgetBuilder
{
    public static function build(\stdClass $row): UsedBudgetVO
    {
        return new UsedBudgetVO(
            total_presupuesto: (float) $row->total_presupuesto,
            total_gastos: (float) $row->total_gastos,
            disponible: (float) $row->disponible
        );
    }
}