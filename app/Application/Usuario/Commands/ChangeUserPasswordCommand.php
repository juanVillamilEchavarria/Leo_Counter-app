<?php

namespace App\Application\Usuario\Commands;

/**
 * Comando para cambiar la contraseña de un usuario desde administración.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Usuario\Commands
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class ChangeUserPasswordCommand
{
    public function __construct(
        public string $id,
        public string $newPassword,
    ) {
    }
}
