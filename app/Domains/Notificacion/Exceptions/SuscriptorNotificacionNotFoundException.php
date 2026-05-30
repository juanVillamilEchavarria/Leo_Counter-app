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

use Exception;

/**
 * Excepción lanzada cuando no se encuentra una suscripción de notificación por su id.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Notificacion\Exceptions
 * @since 1.0.0
 * @version 1.0.0
 */
final class SuscriptorNotificacionNotFoundException extends Exception
{
}
