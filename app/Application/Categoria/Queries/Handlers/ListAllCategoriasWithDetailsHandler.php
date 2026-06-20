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
use App\Application\Categoria\Contracts\Queries\Executors\CategoriaQueryExecutorContract;
use App\Application\Categoria\Queries\ListAllCategoriasWithDetailsQuery;
use App\Shared\Domain\Contracts\CollectionContract;

/**
 * Handler encargado de manejar la consulta de listar todas las categorías con detalles completos.
 * Este handler recibe un query de tipo ListAllCategoriasWithDetailsQuery y delega la ejecución de la consulta al ejecutor correspondiente, que implementa el contrato CategoriaQueryExecutorContract.
 * El resultado de la consulta se devuelve al llamador, que puede ser un controlador o cualquier otro componente de la capa de presentación que necesite obtener la lista de categorías con detalles completos.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Categoria\Queries\Handlers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class ListAllCategoriasWithDetailsHandler
{
    public function __construct(
        /**
         * @param CategoriaQueryExecutorContract $listCategoriesQueryExecutor El ejecutor encargado de manejar la consulta de listar categorías
         */
        private CategoriaQueryExecutorContract $listCategoriesQueryExecutor
    ) {
    }

    /**
     * Maneja la consulta de listar todas las categorías con detalles completos.
     * @param ListAllCategoriasWithDetailsQuery $query El query que representa la intención de obtener todas las categorías con detalles completos.
     * @return CollectionContract Una colección de resultados que representa las categorías obtenidas con detalles completos.
     */
    public function __invoke(ListAllCategoriasWithDetailsQuery $query) : CollectionContract
    {
        return $this->listCategoriesQueryExecutor->execute($query);
    }
}
