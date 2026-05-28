<?php

namespace App\Application\Auth\Exceptions;

/**
 * Excepcion lanzada cuando el token de restablecimiento no existe o no es valido.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Auth\Exceptions
 * @since 1.0.0
 * @version 1.0.0
 */
final class InvalidPasswordResetTokenException extends \RuntimeException
{
}
