<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Usuario\Exceptions;

use App\Shared\Application\Exceptions\ApplicationException;
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
final class CannotFindUsuarioException extends ApplicationException
{
    public function __construct(string $message = 'No se pudo encontrar el usuario', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
