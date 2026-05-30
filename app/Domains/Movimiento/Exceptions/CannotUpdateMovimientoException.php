<?php

namespace App\Domains\Movimiento\Exceptions;

use App\Shared\Domain\Exceptions\DomainException;
use Throwable;

class CannotUpdateMovimientoException extends DomainException
{
    public function __construct(string $message = "no se pudo actualizar el movimiento", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
