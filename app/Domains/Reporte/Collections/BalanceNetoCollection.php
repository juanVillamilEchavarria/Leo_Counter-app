<?php

namespace App\Domains\Reporte\Collections;

use App\Domains\Reporte\ValueObjects\BalanceNeto\BalanceNetoVO;
use App\Shared\Domain\Collections\DomainCollection;

final class BalanceNetoCollection extends DomainCollection
{
    public function totalBalance(): float
    {
        return $this->sum(fn(BalanceNetoVO $item) => $item->balance);
    }
}
