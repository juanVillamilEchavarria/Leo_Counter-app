<?php

namespace App\Application\Usuario\DTOs;


/**
 * DTO con los datos necesarios para editar el perfil del usuario.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Usuario\DTOs
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class UsuarioEditDTO
{
    public function __construct(
        public string $id,
        public string $name,
        public string $email,
        public bool $isSuscribed
    ) {
    }
}
