<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Categoria\Queries;

use App\Application\Categoria\Contracts\Queries\ListCategoriasQueryContract;

/**
 * Query que representa la intención de obtener el conteo de registros de categorías.
 * Este query se utiliza para consultas que requieren únicamente el número total de categorías registradas en el sistema.
 * Implementa el contrato ListCategoriasQueryContract para ser compatible con los query executors que manejan consultas de categorías.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Categoria\Queries
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class GetCategoriaRecordsCountQuery  implements ListCategoriasQueryContract
{
}
