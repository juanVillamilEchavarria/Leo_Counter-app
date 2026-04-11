<?php

namespace App\Domains\Reporte\ValueObjects\Form;

use App\Shared\Domain\Collections\DomainCollection;
final class IngresoAndGastoCategoriaVO
{
    public function __construct(
        public DomainCollection $ingresos,
        public DomainCollection $gastos
    ) {
    }
}
