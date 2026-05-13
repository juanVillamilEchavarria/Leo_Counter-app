<?php

namespace App\Application\Movimiento\Validators;

final readonly class MovimientoAttachmentValidator
{

    public function validateNumberOfFiles(array $comprobantes): bool{
        return count($comprobantes) > 3 ? throw new CannotUploadException('No se pude subir mas de 3 archivos') : true;
    }
}
