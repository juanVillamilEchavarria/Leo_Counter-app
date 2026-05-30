<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\Usuario\Exceptions;

use App\Shared\Domain\Exceptions\DomainException;

class CannotCreateTheAdminUserException extends DomainException
{
    public function __construct(string $message = "No se pudo crear el usuario administrador", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
