<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Shared\Infrastructure\Queries\Executors;

use App\Shared\Application\Contracts\Queries\QueryContract;
use App\Shared\Application\DTOs\PaginatedTableResultDTO;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use App\Shared\Application\DTOs\WhereFilterQueryDTO;
use App\Shared\Application\Queries\TableQuery;
use App\Shared\Domain\Contracts\CollectionContract;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;

/**
 * Clase que se encarga de hacer la paginacion de un listado de un modelo para los filtros de una tabla (server side)
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 * @package App\Shared\Infrastructure\Queries\Executors
 */
abstract readonly class EloquentPaginatedTableQueryExecutor{
        /**
     * Funcion que se encarga de hacer la filtracion entera de la tabla (busqueda, ordenamiento y paginacion)
     * @param TableQuery $dto
     * @param WhereFilterQueryDTO[] $initialWheres
     * @return LengthAwarePaginator
     */

    public function execute(TableQuery $dto): PaginatedTableResultDTO{
        $query = $this->queryWithRelations();
        if(!empty($this->initialWheres())){
            $query = $this->applyWheres($query, $this->initialWheres());
        }

        $paginator = $this->applyPaginate($dto, $query);

        return new PaginatedTableResultDTO(
            items: LaravelCollection::make($paginator->items()),
            total: $paginator->total(),
            perPage: $paginator->perPage(),
            currentPage: $paginator->currentPage(),
            lastPage: $paginator->lastPage(),
        );
    }
    /**
     * Retorna el modelo asociado
     * @return string
     */
    abstract protected function model(): string;
    /**
     * Retorna las relaciones que se pueden cargar con los registros del modelo
     * Formato: [relacion1, relacion2]
      * @return array<string>
     */
    abstract protected function modelRelations(): array;
    /**
     * Retorna las columnas que se pueden buscar en la tabla, estas columnas se utilizan para aplicar la busqueda de strings en la tabla, opcionalmente puede tener relaciones con otras tablas
     * formato: [relacion1 => [columna1, columna2], relacion2 => [columna3, columna4]]
      * @return array<string|array<string>>
     */

    abstract protected function searchColumns(): array;

    /**
     * Retorna las relaciones que se pueden ordenar.
     *Formato: [
        * 'sortKey' => [
        *   'relation' => 'relationName',
        *   'column' => 'table.column'
     *      ]
     *  ]
     * @return array<string|array<string>>
     */
    abstract protected function modelSorteableRelations(): array;
    /**
     * Retorna los wheres iniciales que se deben aplicar a la consulta, debe ser sobrescrito en las clases que hereden de esta clase.
     * totalmente opcional, si no aplica, debe retornar un array vacio
     * @return array<WhereFilterQueryDTO>
     */
    protected function initialWheres(): array{
        return [];
    }
    /**
     * Retorna la consulta con las relaciones declaradas en la funcion modelRelations
     * @return Builder
     */
    protected function queryWithRelations():Builder{
        return $this->model()::query()->with($this->modelRelations());
     }


    /**
     * Funcion que aplica la busqueda de strings en la tabla, verifica si en las columnas que debe buscar, hay un array (relaciones), si es asi, aplica la busqueda en la relacion, sino aplica la busqueda en la columna
     * @param Builder $query
     * @param array<string|array<string>> $searchColumns
     * @param string $search
     * @return Builder<Model>
     */
    protected function applySearch(Builder $query, array $searchColumns, string $search): Builder{
        $query->where(function ($query) use ($searchColumns, $search) {
            $isFirst = true;
            foreach ($searchColumns as $relation => $column) {
                   $query= is_array($column)?
                    $this->applyRelationSearch($query, $relation, $column, $search, $isFirst) :
                    $this->applyColumnSearch($query, $column, $search, $isFirst);
                $isFirst = false;
            }
        });

        return $query;
    }

    /**
     * Funcion que aplica la consulta de busqueda en los campos normales de la tabla
     * @param Builder $query
     * @param string $column
     * @param string $search
     * @param bool $isFirst
     * @return Builder<Model>
     */
    private function applyColumnSearch(Builder $query, string $column, string $search, bool $isFirst): Builder{
        return $isFirst ?
        $query->where($column, 'like', "%$search%") :
        $query->orWhere($column, 'like', "%$search%");
    }
    /**
     * Funcion que aplica la consulta de busqueda en las relaciones de la tabla
     * @param Builder $query
     * @param string $relation
     * @param array<string> $columns
     * @param string $search
     * @param bool $isFirst
     * @return Builder<Model>
     */
    private function applyRelationSearch(Builder $query, string $relation, array $columns, string $search, bool $isFirst): Builder{
        $method = $isFirst ? 'whereHas' : 'orWhereHas';
        return $query->{$method}($relation, function ($q) use ($columns, $search) {
                $q->where(function ($subQuery) use ($columns, $search) {
                    $first = true;
                    foreach ($columns as $column) {// recorre cada columna y aplica la busqueda
                        if ($first) {
                            $subQuery->where($column, 'like', "%$search%");
                            $first = false;
                        } else {
                            $subQuery->orWhere($column, 'like', "%$search%");
                        }
                    }
                });
            });
    }



    /**
     * Funcion que se encarga de hacer la filtracion entera de la tabla (busqueda, ordenamiento y paginacion), esta funcion se utiliza en el metodo paginate, se encarga de aplicar la busqueda, el ordenamiento y la paginacion
     * @param TableQuery $dto
      * @param Builder|null $query
     * @return LengthAwarePaginator
     */
    protected function applyPaginate ( TableQuery $dto, ?Builder $query = null): LengthAwarePaginator{
        $query === null && $query = $this->queryWithRelations();
        if(!empty($dto->search)){
            $query = $this->applySearch($query, $this->searchColumns(), $dto->search);
        }
        if(!empty($dto->sortBy) && !empty($dto->sortOrder)){
           $query = $this->applySort($dto, $query);
        }
        return $query->paginate($dto->perPage);

    }

    /**
     * Funcion que ordena las consultas, verifica si la relacion esta declarada en las propiedades del objeto, y si es asi, aplica el ordenamiento de las relaciones, si no, aplica un ordenamiento normal
     * @param TableQuery $dto
      * @param Builder $query
      * @return Builder<Model>
     */
    protected function applySort(TableQuery $dto, Builder $query){
        if(array_key_exists($dto->sortBy, $this->modelSorteableRelations())){
            return $this->executeOrderQueryWithRelations($dto, $query);
        }
        return $query->orderBy($dto->sortBy, $dto->sortOrder);
    }
    /**
     * Funcion que aplica un array de wheres a una consulta, esta funcion se utiliza para aplicar los filtros de busqueda en la tabla, recibe un array de WhereFilterQueryDTO, y aplica cada uno de los filtros a la consulta, devuelve la consulta con los filtros aplicados
     * @param Builder $query
     * @param WhereFilterQueryDTO[] $wheres
     * @return Builder<Model>
     */
     protected function applyWheres(Builder $query, array $wheres): Builder{
        /** @var WhereFilterQueryDTO[] $wheres */
        foreach($wheres as $where){
            $query->where($where->column, $where->operator->value, $where->value, $where->logic);
        }
        return $query;
    }
    /**
     * Funcion que aplica el ordenamiento de las relaciones de la tabla y aplica la busqueda en las relaciones
     * @param TableQuery $dto
     * @param Builder $query
     * @return Builder<Model>
     */
    private function executeOrderQueryWithRelations (TableQuery $dto, Builder $query): Builder{
        /**
         * obtiene las relaciones declaradas como sorteables (ordenables) de la tabla
         * @var array<string|array<string>> $relationData
         */
        $relationData = $this->modelSorteableRelations()[$dto->sortBy];
        /**
         * Obtiene el nombre de la relacion
         */
            $relation = $relationData['relation'];
            /**
             * Obtiene la columna de la relacion
             */
            $column = $relationData['column'];
            $relationInstance = $this->model()::query()->getModel()->{$relation}();
            // Obtiene la tabla de la relacion
            $relatedTable = $relationInstance->getRelated()->getTable();
            // obtiene la llave foranea de la relacion, de la tabla principal
            $foreignKey = $relationInstance->getQualifiedForeignKeyName();
            // Obtiene la clave propia de la relacion, es decir la llave de la tabla relacionada
            $ownerKey = $relationInstance->getQualifiedOwnerKeyName();
            return $query->leftJoin($relatedTable, $foreignKey, '=', $ownerKey)
                    ->orderBy($column, $dto->sortOrder) // ordena por la columna de la relacion y en el orden indicado
                    ->select($this->model()::query()->getModel()->getTable().'.*'); // selecciona todas las columnas de la tabla principal
    }
}
