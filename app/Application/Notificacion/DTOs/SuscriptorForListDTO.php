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
final readonly class SuscriptorForListDTO
{
    public function __construct(
        public string $id,
        public string $usuario,
        public string $canal,
        public bool $active,
        public bool $verified
    ){}
}
