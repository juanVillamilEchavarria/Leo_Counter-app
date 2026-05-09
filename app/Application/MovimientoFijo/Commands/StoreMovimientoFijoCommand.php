<?php

namespace App\Application\MovimientoFijo\Commands;

use App\Application\MovimientoFijo\Commands\Abstracts\WriteMovimientoFijoCommand;

/**
 * Comando que representa la intencion de crear un movimiento fijo.
 * Transporta datos primitivos desde la capa de presentacion hacia el handler de aplicacion.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\MovimientoFijo\Commands
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class StoreMovimientoFijoCommand extends WriteMovimientoFijoCommand
{
}
