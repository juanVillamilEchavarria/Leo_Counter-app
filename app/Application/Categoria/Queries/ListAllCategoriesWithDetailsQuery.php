<?php

namespace App\Application\Categoria\Queries;

use App\Application\Categoria\Contracts\Queries\ListCategoriesQueryContract;

/**
 * Query que representa la intención de obtener todas las categorías con detalles completos.
 * Este query se utiliza para consultas que requieren la información completa de las categorías, incluyendo relaciones y detalles adicionales.
 * Implementa el contrato ListCategoriesQueryContract para ser compatible con los query executors que manejan consultas de categorías.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Categoria\Queries
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class ListAllCategoriesWithDetailsQuery  implements ListCategoriesQueryContract
{
}