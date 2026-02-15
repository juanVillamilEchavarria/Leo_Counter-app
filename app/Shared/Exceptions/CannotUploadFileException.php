<?php

namespace App\Shared\Exceptions;

use App\Shared\Abstracts\Exceptions\DomainException;

class CannotUploadFileException extends DomainException {
    public function __construct($message = 'No se pudo subir el archivo')
    {
        parent::__construct($message);
    }
}