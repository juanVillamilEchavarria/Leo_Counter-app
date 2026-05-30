<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Shared\Infrastructure\Exceptions;

use App\Shared\Domain\Exceptions\DomainException;

/**
 * Excepcion que se lanza cuando no se puede subir un archivo, puede ser por diferentes razones como que el archivo sea demasiado grande, que el formato del archivo no sea permitido, que haya un error en el servidor, entre otras razones
 * @package App\Shared\Exceptions
 */
class CannotUploadFileException extends DomainException {
    public function __construct($message = 'No se pudo subir el archivo')
    {
        parent::__construct($message);
    }
}
