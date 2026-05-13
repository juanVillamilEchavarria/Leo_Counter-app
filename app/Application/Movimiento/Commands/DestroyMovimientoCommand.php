<?php

namespace App\Application\Movimiento\Commands;

/**
 * Comando para eliminar un registro de movimiento.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class DestroyMovimientoCommand
{
public function __construct(
    public string $id,
    public string $user_password
)
{
}
}
