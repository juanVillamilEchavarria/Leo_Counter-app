<?php

namespace App\Domains\Reporte\Collections;

use App\Domains\Reporte\ValueObjects\Gastos\GastoVO;
use App\Shared\Domain\Collections\DomainCollection;

final class GastosCollection extends DomainCollection
{
    public function totalMonto(): float
    {
        return $this->sum(fn(GastoVO $item) => $item->monto);
    }

    public function totalGastos(): int
    {
        return $this->count();
    }
}
