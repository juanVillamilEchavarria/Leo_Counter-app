<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\Notificacion\Exceptions;

use App\Shared\Domain\Exceptions\DomainException;

/**
 * Excepción lanzada cuando no es posible almacenar una suscripción de notificación.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Notificacion\Exceptions
 * @since 1.0.0
 * @version 1.0.0
 */
final class CannotStoreSuscriptorNotificacionException extends DomainException
{
}
