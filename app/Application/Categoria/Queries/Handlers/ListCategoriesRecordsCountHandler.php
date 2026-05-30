<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Categoria\Queries\Handlers;

use App\Application\Categoria\Contracts\Queries\Executors\GetCategoriaRecordsCountQueryExecutorContract;
use App\Application\Categoria\Queries\ListCategoriesRecordsCountQuery;
/**
 * Handler encargado de manejar la consulta para obtener el conteo de registros de categorías.
 * Este handler recibe un query de tipo ListCategoriesRecordsCountQuery y utiliza un executor para ejecutar la consulta y obtener el resultado.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Categoria\Queries\Handlers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class ListCategoriesRecordsCountHandler 
{
    public function __construct(
        private GetCategoriaRecordsCountQueryExecutorContract $executor
    )
    {
    }
    /**
     * Obtiene el conteo de registros de categorías.
     * @param ListCategoriesRecordsCountQuery $query El query que representa la intención de obtener el conteo de registros de categorías.
     * @return int El número total de categorías registradas en el sistema.
     */
    public function __invoke(ListCategoriesRecordsCountQuery $query): int
    {
        return $this->executor->execute();
    }
}
