<?php

namespace App\Application\Usuario\Commands;

/**
 * Comando para crear un usuario member desde administración.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Usuario\Commands
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class StoreUsuarioCommand
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    ) {
    }
}
