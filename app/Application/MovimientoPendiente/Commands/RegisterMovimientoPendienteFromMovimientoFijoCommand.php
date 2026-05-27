<?php

namespace App\Application\MovimientoPendiente\Commands;

use App\Domains\MovimientoFijo\Aggregates\MovimientoFijo;

/**
 * Commando de registro de un movimiento pendiente a partir de un movimiento fijo.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\MovimientoPendiente\Commands
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class RegisterMovimientoPendienteFromMovimientoFijoCommand
{
    public function __construct(
        public MovimientoFijo $movimientoFijo
    )
    {
    }

}
