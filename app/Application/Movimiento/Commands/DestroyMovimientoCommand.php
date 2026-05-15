<?php

namespace App\Application\Movimiento\Commands;
use App\Application\Movimiento\Contracts\Commands\ModifyMovimientoCommandContract;
/**
 * Comando para eliminar un registro de movimiento.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class DestroyMovimientoCommand implements  ModifyMovimientoCommandContract
{
public function __construct(
    public string $id,
    public string $attempt_password
)
{
}
}
