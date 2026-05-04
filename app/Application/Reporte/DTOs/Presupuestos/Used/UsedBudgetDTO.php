<?php

namespace App\Application\Reporte\DTOs\Presupuestos\Used;
use App\Shared\Abstracts\DTOs\DTO;

/**
 * DTO para representar el presupuesto utilizado en un periodo específico.
 * Este objeto es quien se ensamblara a partir del UsedBudgetVO para ser consumido por la capa de presentación.
 * Contiene el total gastado, el total presupuestado, el porcentaje usado y el presupuesto disponible.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @version 1.0.0
 * @since 1.0.0
 * @see App\Domains\Reporte\ValueObjects\Budget\UsedBudgetVO - Objeto de dominio desde el cual se ensamblará este DTO
 * @see App\Application\Reporte\Assemblers\Presupuestos\UsedBudgetAssembler - Ensamblador encargado de transformar UsedBudgetVO a UsedBudgetDTO
 */
class UsedBudgetDTO extends DTO{
    public function __construct(
        public float $gastado,
        public float $presupuestado,
        public float $porcentaje_usado,
        public float $disponible
    )
    {
    }
}