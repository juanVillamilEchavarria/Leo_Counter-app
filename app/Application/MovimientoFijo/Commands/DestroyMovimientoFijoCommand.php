<?php

namespace App\Application\MovimientoFijo\Commands;

/**
 * Comando que representa la intencion de eliminar un movimiento fijo.
 * Expone unicamente la identidad del agregado que debe ser eliminado.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\MovimientoFijo\Commands
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class DestroyMovimientoFijoCommand
{
    public function __construct(
        public string $id,
    ) {
 }
}
