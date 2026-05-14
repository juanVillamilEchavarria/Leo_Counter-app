<?php

namespace App\Application\MovimientoPendiente\Commands;

/**
 * Comando de escritura para marcar un movimiento pendiente como hecho
 * @package App\Application\MovimientoPendiente\Commands
 * @since 1.0.0
 * @version 1.0.0
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 */
final readonly class MarkAsDoneMovimientoPendienteCommand
{
    public function __construct(
        public string $id,
        public ?array $comprobantes
    )
    {
    }
}
