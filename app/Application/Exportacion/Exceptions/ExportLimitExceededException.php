<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Application\Exportacion\Exceptions;

use App\Shared\Application\Exceptions\ApplicationException;

/**
 * Excepción lanzada cuando una exportación supera el límite superior de registros.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
final class ExportLimitExceededException extends ApplicationException
{
    public function __construct()
    {
        parent::__construct(
            'La exportación supera el límite de 50.000 registros. Aplica filtros más específicos o exporta solo la página actual.'
        );
    }
}
