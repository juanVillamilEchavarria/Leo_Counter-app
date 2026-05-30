<?php
/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Reporte\DTOs\Movimientos\Averages;

/**
 * DTO que representa los promedios de ingresos y gastos por periodo y por movimiento.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Reporte\DTOs\Movimientos\Averages
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class PromedioDTO {
    public function __construct(
        public ?float $ingresos_por_periodo,
        public ?float $gastos_por_periodo,
        public ?float $ingresos_por_movimiento,
        public ?float $gastos_por_movimiento
    )
    {
    }
}
