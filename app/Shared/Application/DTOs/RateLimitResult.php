<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Shared\Application\DTOs;

/**
 * DTO que encapsula el resultado de una verificación de rate limiting.
 * Contiene toda la información necesaria para que el consumidor decida
 * cómo responder: permitir la operación, bloquearla, o mostrar tiempo de espera.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
final readonly class RateLimitResult
{
    public function __construct(
        /** Si la operación está permitida (no se superó el límite) */
        public bool $allowed,
        /** Número de intentos realizados hasta ahora */
        public int $attempts,
        /** Intentos restantes antes del bloqueo */
        public int $remaining,
        /** Segundos restantes hasta que se libere el bloqueo (0 si no está bloqueado) */
        public int $retryAfterSeconds,
        /** Tiempo de espera formateado en lenguaje humano (vacío si no está bloqueado) */
        public string $retryAfterHuman,
    ) {}
}
