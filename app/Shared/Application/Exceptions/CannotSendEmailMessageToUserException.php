<?php

namespace App\Shared\Application\Exceptions;

use RuntimeException;

final class CannotSendEmailMessageToUserException extends RuntimeException
{
    public function __construct(string $message = "no se pudo enviar el correo al usuario", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }


}
