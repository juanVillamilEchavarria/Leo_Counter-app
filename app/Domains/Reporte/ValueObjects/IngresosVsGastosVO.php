<?php

namespace App\Domains\Reporte\ValueObjects;

use App\Shared\Domain\Collections\DomainCollection;

final class IngresosVsGastosVO
{
    public function __construct(
        public DomainCollection $data,
        public PromedioVO $promedios
    ) {
    }
}
