<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Cuenta\DTOs;
use App\Shared\Domain\Contracts\CollectionContract;

/**
 * DTO que representa las opciones para el formulario de cuenta.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Cuenta\DTOs
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class CuentaFormOptionsDTO{
    public function __construct(
        public  CollectionContract $propietarios,
        public CollectionContract $tipo_cuentas
    ){}
}
