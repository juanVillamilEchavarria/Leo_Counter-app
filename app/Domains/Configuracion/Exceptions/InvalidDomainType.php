<?php

namespace App\Domains\Configuracion\Exceptions;

use App\Shared\Abstracts\Exceptions\DomainException;
use Throwable;

class InvalidDomainType extends DomainException
{
    public function __construct(string $message = "No se encontro un dominio", int $code = 0, Throwable|null $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }
}
