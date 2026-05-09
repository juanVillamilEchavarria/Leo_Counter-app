<?php

namespace App\Domains\MovimientoFijo\Exceptions;

/**
 * Excepcion lanzada cuando el dominio impide crear un movimiento fijo.
 * Representa fallos de invariantes o datos invalidos durante la creacion del agregado.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\MovimientoFijo\Exceptions
 * @since 1.0.0
 * @version 1.0.0
 */
final class CannotStoreMovimientoFijoException extends MovimientoFijoException
{
    public function __construct(string $message = 'No se pudo crear el movimiento fijo.')
    {
        parent::__construct($message);
    }
}
