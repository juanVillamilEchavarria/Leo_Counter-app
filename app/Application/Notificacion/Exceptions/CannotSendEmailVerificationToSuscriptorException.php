<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Notificacion\Exceptions;

class CannotSendEmailVerificationToSuscriptorException extends \RuntimeException
{
    public function __construct(string $message = "No se pudo enviar el correo de verificacion al suscriptor", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
