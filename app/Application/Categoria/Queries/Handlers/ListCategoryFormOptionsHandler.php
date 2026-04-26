<?php

namespace App\Application\Categoria\Queries\Handlers;

use App\Application\Categoria\Queries\ListCategoryFormOptionsQuery;
use App\Application\Categoria\Contracts\Queries\Executors\ListCategoryFormOptionExecutorContract;
use App\Application\Categoria\DTOs\CategoriaFormOptionsDTO;

/**
 * Handler encargado de manejar la consulta para obtener las opciones necesarias para los formularios relacionados con categorías.
 * Este handler recibe un query de tipo ListCategoryFormOptionsQuery y utiliza un executor para ejecutar la consulta y obtener el resultado.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Categoria\Queries\Handlers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class ListCategoryFormOptionsHandler{
    public function __construct(
        /**
         * @param ListCategoryFormOptionExecutorContract $executor El ejecutor encargado de manejar la consulta para obtener las opciones de formulario de categoría.
         * 
         * Si el dia de mañana es necesario agregar mas opciones, seria un iterable del contrato ListCategoryFormOptionExecutorContract, y el handler se encargaria de ejecutar cada uno de los ejecutores para obtener las opciones necesarias para el formulario de categoría.
         */
        private ListCategoryFormOptionExecutorContract $executor
    )
    {
    }

    public function __invoke(ListCategoryFormOptionsQuery $query)
    {
        return new CategoriaFormOptionsDTO(
            tipos: $this->executor->execute($query)
            );
    }
}