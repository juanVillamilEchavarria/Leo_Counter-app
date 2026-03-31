<?php

namespace App\Shared\Exceptions;
use App\Shared\Abstracts\Exceptions\DomainException;
/**
 * Excepcion que se lanza cuando el usuario no tiene suficiente saldo para realizar una accion
 * @package App\Shared\Exceptions
 */
class InsufficientBalanceException extends DomainException {
    public function __construct(string $message = "Centa con Saldo Insuficiente", int $code = 0, \Throwable|null $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }
}