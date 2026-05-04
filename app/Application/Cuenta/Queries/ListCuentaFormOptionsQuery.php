<?php

namespace App\Application\Cuenta\Queries;

use App\Shared\Application\Contracts\Queries\QueryContract;
use App\Application\Cuenta\Contracts\Queries\ListCuentasQueryContract;

/**
 * Query que representa la intención de obtener las opciones necesarias para los formularios relacionados con cuentas.
 * Este query se utiliza para consultas que requieren obtener datos como los tipos de cuentas disponibles para seleccionar en un formulario de cuenta.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Cuenta\Queries
 * @since 1.0.0
 * @version 1.0.0
 * 
 */
final readonly class ListCuentaFormOptionsQuery implements ListCuentasQueryContract
{
}