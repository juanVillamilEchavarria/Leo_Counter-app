<?php

namespace App\Application\Notificacion\Commands;

/**
 * Comando para actualizar la configuración JSON de un canal de notificación.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Notificacion\Commands
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class UpdateCanalNotificacionConfigCommand
{
    public function __construct(
        public string $id,
        public array $configuracion
    ){}
}
