<?php

namespace App\Application\MovimientoPendiente\Commands;

/**
 * Comando que representa la intencion de eliminar un movimiento pendiente.
 * Expone unicamente la identidad del agregado que debe ser eliminado.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\MovimientoPendiente\Commands
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class DestroyMovimientoPendienteCommand
{
    public function __construct(
        public string $id,
    ) {
    }
}
