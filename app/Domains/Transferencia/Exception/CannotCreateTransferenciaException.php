<?php

namespace App\Domains\Transferencia\Exception;
/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
use App\Shared\Domain\Exceptions\ClientFacingException;
use App\Shared\Domain\Exceptions\DomainException;

/**
 * Excepción que ocurre cuando no se puede ejecutar una transferencia.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 */
final  class CannotCreateTransferenciaException extends DomainException implements ClientFacingException{

}
