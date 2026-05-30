<?php

namespace App\Application\Movimiento\Validators;

use App\Shared\Infrastructure\Exceptions\CannotUploadFileException;

/**
 * Validador de archivos adjuntos para movimientos.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Movimiento\Validators
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class MovimientoAttachmentValidator
{

    public function validateNumberOfFiles(int $total): bool{
        return $total > 3 ? throw new CannotUploadFileException('No se pude subir mas de 3 archivos') : true;
    }
}
