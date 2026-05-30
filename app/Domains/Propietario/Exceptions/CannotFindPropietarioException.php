<?php

namespace App\Domains\Propietario\Exceptions;
use App\Shared\Domain\Exceptions\DomainException;
use Override;
use Throwable;

class CannotFindPropietarioException extends DomainException{
    #[Override]
    public function __construct(string $message = "No se pudo encontrar un propietario", int $code = 0, Throwable|null $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }
}
