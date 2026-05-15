<?php

namespace App\Application\ArchivoMovimiento\Commands;

use App\Domains\ArchivoMovimiento\ValueObjects\ArchivoMovimientoId;

/**
 * Command para eliminar un archivo de movimiento.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
class DestroyArchivoMovimientoCommand
{ public function __construct(
    public ArchivoMovimientoId $id
)
{
}

}
