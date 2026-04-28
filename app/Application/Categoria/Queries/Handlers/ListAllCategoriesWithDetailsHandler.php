<?php

namespace App\Application\Categoria\Queries\Handlers;
use App\Application\Categoria\Contracts\Queries\Executors\CategoriaQueryExecutorContract;
use App\Application\Categoria\Queries\ListAllCategoriesWithDetailsQuery;
use App\Shared\Domain\Contracts\CollectionContract;

/**
 * Handler encargado de manejar la consulta de listar todas las categorías con detalles completos.
 * Este handler recibe un query de tipo ListAllCategoriesWithDetailsQuery y delega la ejecución de la consulta al ejecutor correspondiente, que implementa el contrato CategoriaQueryExecutorContract.
 * El resultado de la consulta se devuelve al llamador, que puede ser un controlador o cualquier otro componente de la capa de presentación que necesite obtener la lista de categorías con detalles completos.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Categoria\Queries\Handlers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class ListAllCategoriesWithDetailsHandler 
{
    public function __construct(
        /**
         * @param CategoriaQueryExecutorContract $listCategoriesExecutor El ejecutor encargado de manejar la consulta de listar categorías
         */
        private CategoriaQueryExecutorContract $listCategoriesExecutor
    ) {
    }

    /**
     * Maneja la consulta de listar todas las categorías con detalles completos.
     * @param ListAllCategoriesWithDetailsQuery $query El query que representa la intención de obtener todas las categorías con detalles completos.
     * @return CollectionContract Una colección de resultados que representa las categorías obtenidas con detalles completos.
     */
    public function __invoke(ListAllCategoriesWithDetailsQuery $query) : CollectionContract
    {
        return $this->listCategoriesExecutor->execute($query);
    }
}