<?php

namespace App\Application\Movimiento\Commands;

use App\Application\Movimiento\Commands\Abstracts\WriteMovimientoCommand;
use App\Shared\Application\Contracts\Commands\TransactionalCommandContract;
/**
 * Comando para almacenar un nuevo registro de movimiento.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class StoreMovimientoCommand extends WriteMovimientoCommand implements TransactionalCommandContract
{
}
