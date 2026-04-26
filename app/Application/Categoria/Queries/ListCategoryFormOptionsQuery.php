<?php

namespace App\Application\Categoria\Queries;

use App\Shared\Application\Contracts\Queries\QueryContract;

/**
 * Query que representa la intención de obtener las opciones necesarias para los formularios relacionados con categorías.
 * Este query se utiliza para consultas que requieren obtener datos como los tipo de movimientos disponibles para seleccionar en un formulario de categoría.
 * Implementa el contrato QueryContract para ser compatible con los query executors que manejan consultas generales.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Categoria\Queries
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class ListCategoryFormOptionsQuery implements QueryContract
{
}