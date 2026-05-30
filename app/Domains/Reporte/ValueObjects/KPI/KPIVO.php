<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\Reporte\ValueObjects\KPI;

use App\Domains\Reporte\ValueObjects\Financial\FinancialStatisticVO;

/**
 * Value object que representa los KPIs de un periodo (Ingresos, Gastos, Movimientos y Balance neto, este ultimo obtenido mediante el metodo getBalance).
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @version 1.0.0
 * @since 1.0.0
 */
final class KPIVO extends FinancialStatisticVO
{
    public function __construct(
        float $ingresos,
        float $gastos,
        public int $total_movimientos
    ) {
        parent::__construct($ingresos, $gastos);
    }
}
