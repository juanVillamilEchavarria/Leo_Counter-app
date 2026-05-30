<?php

namespace App\Application\Usuario\Exceptions;

use App\Shared\Domain\Exceptions\DomainException;
use Override;
use Throwable;

/**
 * Excepción lanzada cuando no se encuentra el usuario requerido por un caso de uso.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Usuario\Exceptions
 * @since 1.0.0
 * @version 1.0.0
 */
final class CannotFindUsuarioException extends DomainException
{
    public function __construct(string $message = 'No se pudo encontrar el usuario', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
