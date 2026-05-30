<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Reporte\DTOs\Presupuestos\Used;

use App\Application\Reporte\Assemblers\Presupuestos\UsedBudgetAssembler;
use App\Domains\Reporte\ValueObjects\Budget\UsedBudgetVO;

/**
 * DTO para representar el presupuesto utilizado en un periodo específico.
 * Este objeto es quien se ensamblara a partir del UsedBudgetVO para ser consumido por la capa de presentación.
 * Contiene el total gastado, el total presupuestado, el porcentaje usado y el presupuesto disponible.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @version 1.0.0
 * @since 1.0.0
 * @see UsedBudgetVO - Objeto de dominio desde el cual se ensamblará este DTO
 * @see UsedBudgetAssembler - Ensamblador encargado de transformar UsedBudgetVO a UsedBudgetDTO
 */
final readonly class UsedBudgetDTO{
    public function __construct(
        public float $gastado,
        public float $presupuestado,
        public float $porcentaje_usado,
        public float $disponible
    )
    {
    }
}
