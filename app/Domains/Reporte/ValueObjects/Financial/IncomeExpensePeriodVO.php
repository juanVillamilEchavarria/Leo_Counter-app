<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\Reporte\ValueObjects\Financial;

/**
 * Value object que representa un periodo financiero compuesto por ingresos y gastos
 * Este objeto debe ser la composicion de la coleccion de IncomeExpenseCollection
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @version 1.0.0
 * @since 1.0.0
 */
final class IncomeExpensePeriodVO extends FinancialStatisticVO
{
    public function __construct(
        public string $period,
        float $ingresos,
        float $gastos,
        public int $count_ingresos,
        public int $count_gastos
    ) {
        parent::__construct($ingresos, $gastos);
    }
}
