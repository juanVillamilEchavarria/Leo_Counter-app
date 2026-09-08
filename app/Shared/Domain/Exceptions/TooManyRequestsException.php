<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Shared\Domain\Exceptions;

use RuntimeException;

/**
 * Excepción lanzada cuando se supera el límite de peticiones (rate limit).
 * Implementa ClientFacingException para que el mensaje sea presentado
 * directamente al usuario final a través del sistema de errores de Inertia.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
final class TooManyRequestsException extends RuntimeException implements ClientFacingException
{
    public function __construct(
        public readonly int $retryAfterSeconds,
        public readonly string $retryAfterHuman,
        string $message,
    ) {
        parent::__construct($message);
    }
}
