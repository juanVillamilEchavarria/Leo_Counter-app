<?php

namespace App\Application\Categoria\Contracts\Queries\Executors;

use App\Application\Categoria\Contracts\Queries\ListCategoriesQueryContract;
use App\Shared\Domain\Contracts\CollectionContract;

/**
 * Contrato que deben implementar los query executors encargados de manejar consultas de categorías.
 * Este contrato define el método `execute` que recibe un query de tipo ListCategoriesQueryContract y devuelve una colección de categorías o un conteo de registros, dependiendo del query ejecutado.
 * @author JuanVillamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Categoria\Contracts\Queries\Executors
 * @since 1.0.0
 * @version 1.0.0
 */
interface CategoriaQueryExecutorContract{
    /**
     * Ejecuta la consulta para obtener una lista de categorías según el query proporcionado.
     * @param ListCategoriesQueryContract $query El query que contiene los parámetros de la consulta.
     * @return CollectionContract Resultado de la consulta, que puede ser una colección de categorías
     */
    public function execute(ListCategoriesQueryContract $query): CollectionContract ;
}
