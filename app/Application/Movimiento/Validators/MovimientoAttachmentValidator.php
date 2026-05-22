<?php

namespace App\Application\Movimiento\Validators;

use App\Shared\Exceptions\CannotUploadFileException;

final readonly class MovimientoAttachmentValidator
{

    public function validateNumberOfFiles(int $total): bool{
        return $total > 3 ? throw new CannotUploadFileException('No se pude subir mas de 3 archivos') : true;
    }
}
