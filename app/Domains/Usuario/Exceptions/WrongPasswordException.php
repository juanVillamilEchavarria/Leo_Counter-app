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
use Throwable;

/**
 * Excepción lanzada cuando la contraseña actual del usuario no coincide.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Usuario\Exceptions
 * @since 1.0.0
 * @version 1.0.0
 */
final class WrongPasswordException extends DomainException
{
    public function __construct(string $message = 'La contraseña actual es incorrecta', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
