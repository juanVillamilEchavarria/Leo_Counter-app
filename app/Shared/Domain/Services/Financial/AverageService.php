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
 * Service encargado de calcular el promedio
 */
final class AverageService{
    /**
     * Funcion encargada de calcular el promedio
     * 
     * @param float $total
     * @param int $count
     * @return float
     */
    public static function average(float $total, int $count): float{
        return $count > 0 ? $total / $count : 0;
    }
}