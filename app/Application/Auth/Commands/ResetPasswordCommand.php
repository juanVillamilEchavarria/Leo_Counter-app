<?php

namespace App\Application\Auth\Commands;

/**
 * Comando para restablecer una contraseña usando un token valido.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Auth\Commands
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class ResetPasswordCommand
{
    /**
     * @param string $email Correo electronico del usuario.
     * @param string $token Token de restablecimiento recibido.
     * @param string $password Nueva contraseña plana.
     */
    public function __construct(
        public string $email,
        public string $token,
        public string $password
    ) {
    }
}
