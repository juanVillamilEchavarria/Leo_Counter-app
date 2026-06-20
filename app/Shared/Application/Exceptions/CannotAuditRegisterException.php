<?php
/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
namespace App\Shared\Application\Exceptions;

use App\Shared\Domain\Exceptions\ClientFacingException;

class CannotAuditRegisterException extends ApplicationException implements ClientFacingException
{

}
