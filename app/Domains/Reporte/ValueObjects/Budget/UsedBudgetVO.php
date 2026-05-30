<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\Reporte\ValueObjects\Budget;
use App\Shared\Domain\Services\Financial\PercentageService;

/**
 * Value Object para representar el presupuesto utilizado en un periodo específico.
 * Contiene el total del presupuesto asignado, el total de gastos realizados y el presupuesto disponible.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @version 1.0.0
 * @since 1.0.0
 */
final readonly class UsedBudgetVO
{
    /**
     * @param float $total_presupuesto El total del presupuesto asignado para el periodo.
     * @param float $total_gastos El total de gastos realizados en el periodo.
     * @param float $disponible El presupuesto disponible, calculado como total_presupuesto - total_gastos, puede ser negativo si se han excedido los gastos.
     */
    public function __construct(
        public float $total_presupuesto,
        public float $total_gastos,
        public float $disponible
    ) {}

    /**
     * Calcula el porcentaje del presupuesto utilizado, redondeado a 2 decimales.
     * Si el total del presupuesto es 0, devuelve 0 para evitar división por cero
     * @return float El porcentaje del presupuesto utilizado.
     */
    public function percentageUsed(): float{
        return (new PercentageService())->calculatePercentage($this->total_gastos, $this->total_presupuesto);
    }
}