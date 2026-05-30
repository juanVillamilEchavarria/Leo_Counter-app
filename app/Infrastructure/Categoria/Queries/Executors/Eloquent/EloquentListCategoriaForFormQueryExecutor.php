<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\Categoria\Queries\Executors\Eloquent;

use App\Shared\Infrastructure\Framework\Laravel\Collections\FormOptions\LaravelCategoriaForFormCollection;
use App\Shared\Application\Contracts\Queries\Executors\FormOptions\ListCategoriaForFormContract;

use App\Models\Categoria\Categoria;
use App\Shared\Domain\Contracts\CollectionContract;
use Override;

/**
 * Clase que se encarga de traer todas las categorias para mostrar como opcion de un formulario.
 * Trae las categorias solo con el id y el nombre.
 * 
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Infrastructure\Categoria\Queries\Executors\Eloquent
 * @version 1.0.0
 * @since 1.0.0
 */
final readonly class EloquentListCategoriaForFormQueryExecutor implements ListCategoriaForFormContract{
    #[Override]
    public function execute(): CollectionContract
    {
        return LaravelCategoriaForFormCollection::make(Categoria::all(['id', 'nombre', 'tipo_movimiento_id']));
    }
}