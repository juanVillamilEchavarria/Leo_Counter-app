<?php

namespace App\Application\MovimientoPendiente\Queries;

use App\Application\MovimientoPendiente\Contracts\Queries\ListMovimientoPendienteQueryContract;

/**
 * Query que representa la intencion de listar todos los movimientos pendientes con sus detalles.
 * Es manejado por un query executor de infraestructura para obtener datos de lectura.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\MovimientoPendiente\Queries
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class ListAllMovimientoPendienteQuery implements ListMovimientoPendienteQueryContract
{
}
