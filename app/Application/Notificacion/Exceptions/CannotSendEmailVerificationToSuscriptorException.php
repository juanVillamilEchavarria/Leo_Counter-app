<?php

namespace App\Application\Notificacion\Exceptions;

class CannotSendEmailVerificationToSuscriptorException extends \RuntimeException
{
    public function __construct(string $message = "No se pudo enviar el correo de verificacion al suscriptor", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
