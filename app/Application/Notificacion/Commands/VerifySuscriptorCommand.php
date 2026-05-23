<?php

namespace App\Application\Notificacion\Commands;

/**
 * Comando para verificar un suscriptor de notificacion
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class VerifySuscriptorCommand
{
    public function __construct(
        public string $id
    )
    {
    }

}
