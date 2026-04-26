<?php

namespace App\Application\Categoria\Contracts\Queries\Executors;
use App\Shared\Application\Contracts\Queries\QueryContract;
use App\Shared\Domain\Contracts\CollectionContract;

/**
 * Contrato que deben implementar los query executors encargados de obtener las opciones necesarias para los formularios relacionados con categorías.
 * Este contrato define el método `execute` que recibe un query de tipo QueryContract y devuelve una colección de la opcion obtenida, como por ejemplo los tipos de movimientos disponibles para seleccionar en un formulario de categoría.
 * Los query executors que implementen este contrato serán utilizados por el handler ListCategoryFormOptionsHandler para obtener los datos necesarios y construir el DTO correspondiente que se devolverá al llamador.
 * @author JuanVillamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Categoria\Contracts\Queries\Executors
 * @since 1.0.0
 * @version 1.0.0
 */
 interface ListCategoryFormOptionExecutorContract
{
    /**
     * Ejecuta la consulta para obtener la opcion.
     *
     * @param QueryContract $query La consulta que contiene los parámetros necesarios para obtener la opcion.
     * @return CollectionContract Una colección de la opcion obtenida
     */
    public function execute(QueryContract $query): CollectionContract;
}