<?php

namespace App\Domains\Reporte\Collections;

use App\Domains\Reporte\ValueObjects\Ingresos\IngresoVO;
use App\Shared\Domain\Collections\DomainCollection;

final class IngresosCollection extends DomainCollection
{
    public function totalMonto(): float
    {
        return $this->sum(fn(IngresoVO $item) => $item->monto);
    }

    public function totalIngresos(): int
    {
        return $this->count();
    }
}
