<?php

namespace App\Infrastructure\Categoria\Queries\Executors\Eloquent;
use App\Application\Categoria\Contracts\Queries\Executors\CategoriaQueryExecutorContract;
use App\Application\Categoria\Contracts\Queries\ListCategoriesQueryContract;
use App\Shared\Domain\Contracts\CollectionContract;
use App\Models\Categoria\Categoria;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;
/**
 * Ejecutor encargado de manejar la consulta de listar todas las categorías con detalles completos utilizando Eloquent ORM.
 * Este ejecutor implementa el contrato CategoriaQueryExecutorContract, lo que garantiza que puede ser utilizado por cualquier handler que requiera ejecutar una consulta de listado de categorías.
 *
 * El método `list` recibe un query de tipo ListCategoriesQueryContract y devuelve una colección de resultados que representa las categorías obtenidas con detalles completos, incluyendo las relaciones definidas en el modelo Eloquent.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Infrastructure\Categoria\Queries\Executors\Eloquent
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class EloquentListAllCategoriesWithDetailsQueryExecutor implements CategoriaQueryExecutorContract{
    private function relations (){
        return [
            'tipo_movimiento'
        ];
    }
    public function execute(ListCategoriesQueryContract $query): CollectionContract
    {
        return new LaravelCollection(Categoria::with($this->relations())->get());
    }
}
