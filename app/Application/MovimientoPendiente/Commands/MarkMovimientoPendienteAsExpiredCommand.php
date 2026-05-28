<?php

namespace App\Application\MovimientoPendiente\Commands;

use App\Domains\MovimientoPendiente\Aggregates\MovimientoPendiente;

/**
 * Comando para marcar un movimiento pendiente como vencido.
 * @package App\Application\MovimientoPendiente\Commands
 * @since 1.0.0
 * @version 1.0.0
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 */
final readonly class MarkMovimientoPendienteAsExpiredCommand
{
    public function __construct(
        public MovimientoPendiente $movimientoPendiente
    )
    {
    }

}
