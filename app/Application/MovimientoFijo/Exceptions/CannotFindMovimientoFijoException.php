<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\MovimientoFijo\Exceptions;

use RuntimeException;

/**
 * Excepcion de aplicacion lanzada cuando no existe el movimiento fijo solicitado.
 * Se utiliza en casos de uso de consulta o actualizacion que requieren un agregado existente.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\MovimientoFijo\Exceptions
 * @since 1.0.0
 * @version 1.0.0
 */
final class CannotFindMovimientoFijoException extends RuntimeException
{
    public function __construct(string $message = 'No se encontro el movimiento fijo solicitado.')
    {
        parent::__construct($message);
    }
}
