<?php
/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Shared\Application\Exceptions;

use RuntimeException;
use App\Shared\Domain\Exceptions\ClientFacingException;

/**
 * Excepcion base para errores relacionados con la lógica de aplicación.
 */
abstract class ApplicationException extends RuntimeException implements ClientFacingException {}
