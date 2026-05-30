<?php

namespace App\Domains\Usuario\Exceptions;

use App\Shared\Domain\Exceptions\DomainException;

class CannotCreateTheAdminUserException extends DomainException
{
    public function __construct(string $message = "No se pudo crear el usuario administrador", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
