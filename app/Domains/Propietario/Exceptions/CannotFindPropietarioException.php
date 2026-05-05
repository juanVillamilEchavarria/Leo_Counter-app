<?php

namespace App\Domains\Propietario\Exceptions;
use App\Shared\Abstracts\Exceptions\DomainException;
use Throwable;
use Override;

class CannotFindPropietarioException extends DomainException{
    #[Override]
    public function __construct(string $message = "No se pudo encontrar un propietario", int $code = 0, Throwable|null $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }
}