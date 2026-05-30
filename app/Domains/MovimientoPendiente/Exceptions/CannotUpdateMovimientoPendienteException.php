<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\MovimientoPendiente\Exceptions;

use Exception;

class CannotUpdateMovimientoPendienteException extends Exception
{
    public function __construct($message = "No se puede actualizar el movimiento pendiente", $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
