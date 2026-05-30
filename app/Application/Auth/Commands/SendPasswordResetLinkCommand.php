<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Auth\Commands;

/**
 * Comando para solicitar el envio de un enlace de restablecimiento de contraseña.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Auth\Commands
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class SendPasswordResetLinkCommand
{
    /**
     * @param string $email Correo electronico que solicita el restablecimiento.
     */
    public function __construct(
        public string $email
    ) {
    }
}
