<?php

namespace App\Domains\Reporte\Services;

/**
 * Clase para hacer calculos relacionados al presupuesto
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @version 1.0.0
 * @since 1.0.0
 */
final class BudgetService{
    /**
     * Calcula el presupuesto disponible
     * @param float $gastado
     * @param float $presupuestado
     * @return float
     */
    public function calculateAvailable(float $gastado, float $presupuestado): float{
        return $gastado < $presupuestado ? $presupuestado - $gastado : 0.0;
    }
}