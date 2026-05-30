<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
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
