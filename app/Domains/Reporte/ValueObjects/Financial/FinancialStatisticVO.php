<?php

namespace App\Domains\Reporte\ValueObjects\Financial;

/**
 * Value object abstracto para representar un los datos financieros obtenidos de una consulta, basado en movimientos  de tipo ingreso y gasto.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @version 1.0.0
 * @since 1.0.0
 */
abstract class FinancialStatisticVO
{
    public function __construct(
        public float $ingresos,
        public float $gastos
    ) {
    }

    /**
     * Obtiene el balance neto de ingresos y gastos
     */
    public function getBalance(): float
    {
        return $this->ingresos - $this->gastos;
    }
}
