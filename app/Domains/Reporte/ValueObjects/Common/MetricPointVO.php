<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\Reporte\ValueObjects\Common;

/**
 * Representa un punto de dato métrico (fecha y valor) para reportes.
 * Ejemplo de uso: representacion de gastos por fecha
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @version 1.0.0
 * @since 1.0.0
 */
final class MetricPointVO
{
    /**
     * @param string $fecha - fecha / periodo de referencia
     * @param float $monto - valor de la metrica
     */
    public function __construct(
        public string $fecha,
        public float $monto
    ) {
    }
}