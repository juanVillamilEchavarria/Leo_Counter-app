<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Cuenta\Exceptions;

use App\Shared\Application\Exceptions\ApplicationException;
use Throwable;

class CannotFindCuentaException extends ApplicationException {
    public function __construct(string $message = "No se puede encontrar la cuenta", int $code = 0, Throwable|null $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }
}
