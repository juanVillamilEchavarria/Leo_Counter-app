<?php
/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Reporte\DTOs\Movimientos\KPI;

/**
 * DTO que representa las variaciones de key perfomance indicators.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Reporte\DTOs\Movimientos\KPI
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class VariationsKPIDTO {
    public function __construct(
        public ?float $ingresos,
        public ?float $gastos,
        public ?float $balance_neto,
        public ?float $movimientos
    )
    {
    }
}
