<?php

namespace App\Application\Presupuesto\DTOs;
use App\Application\Presupuesto\Queries\Handlers\ListAllCurrentMonthPresupuestosHandler;
/**
 * DTO que encapsula los datos de un presupuesto del mes actual para formar una lista y enviar a la capa de presentacion.
 * se usa en el ListAllCurrentMonthPresupuestosHandler.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Presupuesto\DTOs
 * @since 1.0.0
 * @version 1.0.0
 * @see ListAllCurrentMonthPresupuestosHandler
 */
final readonly class CurrentMonthPresupuestoForListDTO
{
    /**
     * @param string $id
     * @param string $categoria
     * @param string $periodo
     * @param float $monto
     * @param string $descripcion
     * @param bool $isDuplicate - indica si el presupuesto ya esta duplicado para el proximo mes
     */
    public function __construct(
        public string $id,
        public ?string $categoria,
        public ?string $user,
        public string $periodo,
        public float $monto,
        public string $descripcion,
        public bool $isDuplicate
    )
    {
    }

}
