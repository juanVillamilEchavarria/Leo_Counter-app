<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\MovimientoPendiente\Exceptions;

use App\Shared\Application\Exceptions\ApplicationException;

/**
 * Excepcion de aplicacion lanzada cuando no se encuentra el movimiento pendiente solicitado.
 * Se utiliza en casos de uso de consulta o actualizacion que requieren un agregado existente.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\MovimientoPendiente\Exceptions
 * @since 1.0.0
 * @version 1.0.0
 */
final class CannotFindMovimientoPendienteException extends ApplicationException
{
    public function __construct(string $message = 'No se encontro el movimiento pendiente solicitado.')
    {
        parent::__construct($message);
    }
}
