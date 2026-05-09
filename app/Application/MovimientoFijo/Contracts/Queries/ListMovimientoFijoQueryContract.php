<?php

namespace App\Application\MovimientoFijo\Contracts\Queries;

use App\Shared\Application\Contracts\Queries\QueryContract;

/**
 * Contrato marcador para queries de listado del modulo MovimientoFijo.
 * Permite que los query executors reciban distintas consultas de lectura sin acoplarse a clases concretas.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\MovimientoFijo\Contracts\Queries
 * @since 1.0.0
 * @version 1.0.0
 */
interface ListMovimientoFijoQueryContract extends QueryContract
{
}
