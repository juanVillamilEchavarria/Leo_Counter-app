<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\Categoria\Queries\Executors;

use App\Application\Categoria\Contracts\Queries\Executors\CategoriaQueryExecutorContract;
use App\Application\Categoria\Contracts\Queries\ListCategoriesQueryContract;
use App\Models\Categoria\Categoria;
use App\Shared\Domain\Contracts\CollectionContract;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;

/**
 * Query executor Eloquent para listar categorías eliminadas.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Infrastructure\Categoria\Queries\Executors
 * @since 1.0.0
 * @version 1.0.0
 */
class EloquentListAllCategoriasDeletedQueryExecutor implements CategoriaQueryExecutorContract
{

    /**
     * @inheritDoc
     */
    public function execute(ListCategoriesQueryContract $query): CollectionContract
    {
       return LaravelCollection::make(Categoria::onlyTrashed()->get());
    }
}
