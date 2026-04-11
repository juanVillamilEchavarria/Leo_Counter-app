<?php

namespace App\Domains\Reporte\ValueObjects\Category;

use App\Shared\Domain\Collections\DomainCollection;

final class FullDistributionCategoryVO
{
    public function __construct(
        public DomainCollection $data,
        public int $total_movimientos
    ) {
    }
}
