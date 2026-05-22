<?php

namespace App\Application\Notificacion\DTOs;

/**
 * Data Transfer Object para Suscriptor de Notificación
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Notificacion\DTOs
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class SuscriptorNotificacionDTO
{
    public function __construct(
        public string $id,
        public string $user_id,
        public string $canal_notificacion_id,
        public bool $activo
    ){}
}
