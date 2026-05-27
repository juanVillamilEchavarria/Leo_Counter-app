<?php

namespace App\Application\MovimientoPendiente\Queries;

use App\Application\MovimientoPendiente\Contracts\Queries\ListMovimientoPendienteQueryContract;
use App\Shared\Application\Contracts\Queries\QueryContract;

/**
 * Query que representa la intencion de obtener todos los movimientos pendientes que deben ser procesados.
 * este query se utiliza en la automatizacion diaria
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\MovimientoPendiente\Queries
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class ListAllMovimientoPendienteDueForProcessingQuery implements ListMovimientoPendienteQueryContract
{

}
