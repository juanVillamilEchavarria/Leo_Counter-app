<?php

namespace App\Application\Notificacion\Commands;

/**
 * Comando para actualizar una suscripción existente.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Notificacion\Commands
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class UpdateSuscriptorCommand
{
    public function __construct(
        public string $id,
        public string $user_id,
        public string $canal_notificacion_id
    ){}
}
