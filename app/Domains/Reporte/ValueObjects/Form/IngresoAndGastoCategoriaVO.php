<?php

namespace App\Domains\Reporte\ValueObjects\Form;

use App\Shared\Domain\Collections\DomainCollection;
use App\Shared\Domain\Contracts\CollectionContract;

final class IngresoAndGastoCategoriaVO
{
    public function __construct(
        public CollectionContract $ingresos,
        public CollectionContract $gastos
    ) {
    }
}
