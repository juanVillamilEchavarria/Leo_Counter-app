<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
namespace App\Domains\MovimientoPendiente\Exceptions;

use App\Shared\Domain\Exceptions\ClientFacingException;
use App\Shared\Domain\Exceptions\DomainException;
use Exception;

class CannotStoreMovimientoPendienteException extends DomainException implements ClientFacingException
{
    public function __construct($message = "No se puede guardar el movimiento pendiente", $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
