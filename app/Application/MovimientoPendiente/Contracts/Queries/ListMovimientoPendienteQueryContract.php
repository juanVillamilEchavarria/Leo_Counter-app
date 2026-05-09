<?php

namespace App\Application\MovimientoPendiente\Contracts\Queries;

use App\Shared\Application\Contracts\Queries\QueryContract;

/**
 * Contrato marcador para queries de listado del modulo MovimientoPendiente.
 * Permite que los query executors reciban distintas consultas de lectura sin acoplarse a clases concretas.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\MovimientoPendiente\Contracts\Queries
 * @since 1.0.0
 * @version 1.0.0
 */
interface ListMovimientoPendienteQueryContract extends QueryContract
{
}
