<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Shared\Infrastructure\Framework\Laravel\Middlewares\Enums;

/**
 * Estrategias disponibles para construir la key del rate limiter.
 * Cada estrategia define cómo se identifica al cliente que hace la petición.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
enum RateLimitType: string
{
    /** Usa el ID del usuario autenticado; si no hay sesión, cae en IP */
    case USER_OR_IP = 'user';

    /** Usa solo la IP del cliente */
    case IP = 'ip';

    /** Usa el valor del campo 'email' del request; si no existe, cae en IP */
    case EMAIL = 'email';

    /** Combina IP + campo 'email' del request (útil para login) */
    case IP_AND_EMAIL = 'ip_email';

    /** Usa el ID del usuario autenticado; si no hay sesión, lanza excepción */
    case USER = 'user_strict';
}
