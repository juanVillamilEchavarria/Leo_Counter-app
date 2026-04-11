<?php

namespace App\Domains\Reporte\Collections;

use App\Domains\Reporte\ValueObjects\KPI\KPIVO;
use App\Shared\Domain\Collections\DomainCollection;

class KPICollection extends DomainCollection
{
    public function totalIngresos(): float
    {
        return $this->sum(fn(KPIVO $mes) => $mes->ingresos);
    }

    public function totalGastos(): float
    {
        return $this->sum(fn(KPIVO $mes) => $mes->gastos);
    }

    public function totalBalance(): float
    {
        return $this->sum(fn(KPIVO $mes) => $mes->getBalance());
    }

    public function totalMovimientos(): int
    {
        return $this->sum(fn(KPIVO $mes) => $mes->total_movimientos);
    }
}
