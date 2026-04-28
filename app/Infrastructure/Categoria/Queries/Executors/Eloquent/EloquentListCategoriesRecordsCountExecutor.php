<?php

namespace App\Infrastructure\Categoria\Queries\Executors\Eloquent;
use App\Application\Categoria\Contracts\Queries\Executors\CategoriaQueryExecutorContract;
use App\Application\Categoria\Contracts\Queries\ListCategoriesQueryContract;
use App\Models\Categoria\Categoria;

/**
 * Ejecutor encargado de manejar la consulta de obtener el conteo de registros de categorías utilizando Eloquent ORM.
 * Este ejecutor implementa el contrato CategoriaQueryExecutorContract, lo que garantiza que puede ser utilizado por cualquier handler que requiera ejecutar una consulta de conteo de registros de categorías.
 * 
 * El método `list` recibe un query de tipo ListCategoriesQueryContract y devuelve un entero que representa el número total de categorías registradas en el sistema, utilizando el método `count` del modelo Eloquent.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Infrastructure\Categoria\Queries\Executors\Eloquent
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class EloquentListCategoriesRecordsCountExecutor implements CategoriaQueryExecutorContract{
    public function execute(ListCategoriesQueryContract $query): int
    {
        return Categoria::count();
    }
}