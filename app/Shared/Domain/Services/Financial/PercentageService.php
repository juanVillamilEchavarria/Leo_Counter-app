<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Shared\Domain\Services\Financial;

/**
 * Servicio de porcentajes
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
class PercentageService{
    /**
     * Funcion encargada de calcular el porcentaje de cambio
     * 
     * @param float $currentValue - valor actual
     * @param float $previousValue - valor anterior
     * 
     * @return float
     */
        public function calculatePercentageChange( float $currentValue, float $previousValue): ?float {
            if($previousValue == 0) {
                return null;
            };
                  return round((($currentValue - $previousValue) / abs($previousValue)) * 100, 2);
    }
    /**
     * Funcion encargada de calcular el porcentaje
     * 
     * @param float $value - valor actual
     * @param float $divider - valor divisor
     * 
     * @return float
     */

    public function calculatePercentage(float $value, float $divider): float {
        if($divider == 0) {
            return 0;
        }
        return round(($value / $divider) * 100, 2);
    }
}