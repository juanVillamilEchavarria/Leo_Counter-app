<?php

namespace App\Domains\Reporte\Collections;

use App\Domains\Reporte\ValueObjects\Category\DistributionCategoryVO;
use App\Shared\Domain\Collections\DomainCollection;

class DistributionCategoryCollection extends DomainCollection
{
    public function totalMovimientos(): int
    {
        return $this->sum(fn(DistributionCategoryVO $mes) => $mes->cantidad);
    }
}
