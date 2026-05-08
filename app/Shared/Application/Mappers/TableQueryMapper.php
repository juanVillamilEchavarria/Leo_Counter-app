<?php
namespace App\Shared\Application\Mappers;
use App\Shared\Application\Contracts\Queries\QueryContract;
use App\Shared\Application\Queries\TableQuery;
/**
 * Clase padre que se encarga de mapear un objeto a un query de aplicacion.
 * Cada modulo en su capa de aplicacion debe crear su implementacion del mapper al query de aplicacion correspondiente extendiendo esta clase.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
abstract readonly class TableQueryMapper{
    /**
     * Retorna el query de aplicacion al que se va a mapear.
     * el query debe ser un hijo de TableQuery e implementar QueryContract
     * @return string
     * @see QueryContract
     * @see TableQuery
     */
    abstract protected function query(): string;

    public function map(object $data){
        $query = $this->query();
        if (!class_exists($query)) {
            throw new \Exception("La clase {$query} no existe.");
        }

        if (!is_subclass_of($query, TableQuery::class) && $query !== TableQuery::class) {
            throw new \Exception("El query debe ser una subclase de TableQuery.");
        }
        /**
         * @var TableQuery $query
         */
        return new $query(
            search: $data->search,
            perPage: $data->perPage,
            sortBy: $data->sortBy,
            sortOrder: $data->sortOrder,
            page: $data->page
        );
    }

}
