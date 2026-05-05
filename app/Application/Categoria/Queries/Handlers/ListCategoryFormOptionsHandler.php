<?php

namespace App\Application\Categoria\Queries\Handlers;

use App\Application\Categoria\Queries\ListCategoryFormOptionsQuery;
use App\Application\Categoria\Contracts\Queries\Executors\ListCategoryFormOptionQueryExecutorContract;
use App\Application\Categoria\DTOs\CategoriaFormOptionsDTO;
use App\Shared\Application\Contracts\Queries\QueryExecutors\FormOptions\ListTipoMovimientoForFormContract;

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
         * @param ListTipoMovimientoForFormContract $executor El ejecutor encargado de manejar la consulta para obtener los tipos de movimiento para mostrar en el formulario.
         * 
         */
        private ListTipoMovimientoForFormContract $executor
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