<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Shared\Domain\Exceptions;


use RuntimeException;


/**
 * Excepcion base para errores relacionados con la lógica de dominio. Estas excepciones representan situaciones que no deberían ocurrir si el código de la aplicación está funcionando correctamente, como violaciones de invariantes o reglas de negocio.
 */
abstract class DomainException extends RuntimeException
{
    //
}
