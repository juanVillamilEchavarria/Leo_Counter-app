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
