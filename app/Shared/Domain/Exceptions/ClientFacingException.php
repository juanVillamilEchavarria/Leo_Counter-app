<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Shared\Domain\Exceptions;

interface ClientFacingException
{
    /**
     * Obtiene el mensaje de error que se mostrará al cliente.
     */
    public function getMessage(): string;
}
