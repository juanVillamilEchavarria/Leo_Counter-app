<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Presupuesto\DTOs;

/**
 * DTO que se encarga de encapsular un presupuesto para la capa de presentacion
 * @author  Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Presupuesto\DTOs
 * @version 1.0.0
 * @since 1.0.0
 */
final readonly class PresupuestoEditDTO
{
    public function __construct(
        public string $id,
        public string $categoria_id,
        public float $monto,
        public string $descripcion
    )
    {
    }

}
