<?php

namespace App\Domains\Profile\Exceptions;


use App\Shared\Abstracts\Exceptions\DomainException;
use Throwable;

class WrongPasswordException extends DomainException
{
   public function __construct(string $message = "contraseña incorrecta", int $code = 0, Throwable|null $previous = null)
   {
    return parent::__construct($message, $code, $previous);
   }
}
