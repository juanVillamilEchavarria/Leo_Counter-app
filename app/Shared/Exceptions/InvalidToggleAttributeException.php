<?php

namespace App\Shared\Exceptions;

use Exception;
use App\Shared\Abstracts\Exceptions\DomainException;
use Throwable;

class InvalidToggleAttributeException extends DomainException
{
    public function __construct(string $message = "Atributo no válido para alternar", int $code = 0, Throwable|null $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }
}
