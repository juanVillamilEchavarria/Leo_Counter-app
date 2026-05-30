<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\Reporte\ValueObjects;

final class PromedioVO
{
    public function __construct(
        public ?float $ingresos_por_periodo,
        public ?float $gastos_por_periodo,
        public ?float $ingresos_por_movimiento,
        public ?float $gastos_por_movimiento
    ) {
    }
}
