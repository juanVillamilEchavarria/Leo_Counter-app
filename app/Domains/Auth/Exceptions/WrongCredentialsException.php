<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\Auth\Exceptions;

use App\Domains\Auth\Exceptions\AuthException;
use Throwable;

class WrongCredentialsException extends AuthException {
    public function __construct(string $message = "Credenciales incorrectas", int $code = 0, Throwable|null $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }
}