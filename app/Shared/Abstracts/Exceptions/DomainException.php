<?php

namespace App\Shared\Abstracts\Exceptions;


use RuntimeException;


/**
 * Excepcion base para errores relacionados con la lógica de dominio. Estas excepciones representan situaciones que no deberían ocurrir si el código de la aplicación está funcionando correctamente, como violaciones de invariantes o reglas de negocio.
 */
abstract class DomainException extends RuntimeException
{
    //
}
