<?php

namespace App\Shared\Infrastructure\Exceptions;

use App\Shared\Domain\Exceptions\DomainException;
use Throwable;

class InvalidToggleAttributeException extends DomainException
{
    public function __construct(string $message = "Atributo no válido para alternar", int $code = 0, Throwable|null $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }
}
