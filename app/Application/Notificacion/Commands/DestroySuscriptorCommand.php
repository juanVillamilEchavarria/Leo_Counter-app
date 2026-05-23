<?php

namespace App\Application\Notificacion\Commands;

/**
 * Comando para eliminar una suscripción.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Notificacion\Commands
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class DestroySuscriptorCommand
{
    public function __construct(
        public string $id
    ){}
}
