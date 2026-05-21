<?php

namespace App\Application\Usuario\Commands;

/**
 * Comando para cambiar la contraseña del usuario autenticado.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Usuario\Commands
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class ChangePasswordCommand
{
    public function __construct(
        public string $id,
        public string $currentPassword,
        public string $newPassword,
    ) {
    }
}
