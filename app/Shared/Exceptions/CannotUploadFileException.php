<?php

namespace App\Shared\Exceptions;

use DomainException;

class CannotUploadFileException extends DomainException {
    public function __construct($message = 'No se pudo subir el archivo')
    {
        parent::__construct($message);
    }
}