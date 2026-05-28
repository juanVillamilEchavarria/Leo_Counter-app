<?php

namespace App\Application\Usuario\Commands;

/**
 * Comando que representa la intencion de crear el usuario administrador del sistema.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Usuario\Commands
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class CreateTheAdminUserCommand
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    ) {
    }

}
