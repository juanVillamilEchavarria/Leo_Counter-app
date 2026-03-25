<?php

namespace App\Shared\Abstracts\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Shared\DTOs\Querys\WhereFilterQueryDTO;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use App\Shared\DTOs\Querys\TableQueryDTO;
use Illuminate\Database\Eloquent\Collection;


abstract class EloquentReadRepository{ 
    /**
     * Configuracion de $relations
     * Formato : ['relationName']
     * @var array<string>
     */
    protected array $relations = [];
    /**
     * Configuracion de $searchColumns
     * 
     * Formato: [
    *   'column_name' => 'column_name',
    *    'relation_name' => ['relation.column']
     *  ]
     * @var array<string|array<string>> 
     */
    protected array $searchColumns = [];

    /**
     * Configuracion de $sortableRelations
     * campos de relacion con otras tablas los cuales pueden ser ordenados en la tabla
     * 
     * Formato: [
        * 'sortKey' => [
        *   'relation' => 'relationName',
        *   'column' => 'table.column'
     *      ]
     *  ]
     * @var array<array<string>>
     */

    protected array $sortableRelations= [];
    /**
     * Configuracion de $forOptionsColumns
     * Formato : ['column_name']
     * @var array<string>
     */

    protected array $forOptionsColumns = [];


    public function __construct(
        /** @var class-string<Model> $model */
        protected string $model
    )
    {
    }
    /**
     * Devuelve los datos necesarios del modelo para mostrarlo como una opcion en un formulario o en un select
     */

    public function getForOptions(): Collection{
        return $this->model::query()->select($this->forOptionsColumns)->get();
    }

    /**
     * Funcion que se encarga de hacer la filtracion entera de la tabla (busqueda, ordenamiento y paginacion)
     */

    public function paginate(TableQueryDTO $dto, array $initialWheres = []): LengthAwarePaginator{
        $query = $this->queryWithRelations();
        if(!empty($initialWheres)){
            $query = $this->applyWheres($query, $initialWheres);
        }
        
        return $this->applyPaginate($dto, $query);
    }

   
    public function getAll(): Collection{
        return $this->model::all();
    }

    /**
     * Obtiene todos los registros con las relaciones declaradas 
     */
    public function getAllWithDetails(): Collection{
        return $this->queryWithRelations()->get();
    }

    /**
     * Obtiene todos los registros con las relaciones declaradas y las filtra con un array de wheres
     * @param WhereQueryFilterDTO[] $wheres
     */
    public function getAllWithDetailsWhere(array $wheres): Collection{
        $data =$this->queryWithRelations()->orderBy('id', 'asc');
        return $this->applyWheres($data, $wheres)->get();
    }
    /**
     * Obtiene un registro con las relaciones declaradas, el modelo debe ser instanciado
     */
    public function getWithDetails(Model $model): Model{
        return $model->load($this->getDetailsRelations());
    }

    /**
     * Aplica un array de wheres
     * @param WhereQueryFilterDTO[] $wheres
     */
    public function where(array $wheres): Builder{
        $data = $this->model::query();
        return $this->applyWheres($data, $wheres);
    }
    /**
     * Aplica un where
     */

    public function whereAttr(string $attribute, $value): Builder{
        return $this->model::query()->where($attribute, $value);
    }

    public function firstOrFail(array $wheres): Model{
        return $this->where($wheres)->firstOrFail();
    }
    public function find(int $id){
        return $this->model::find($id);
    }
    public function getRecordsCount(): int{
        return $this->model::count();
    }
    /**
     * Aplica la consulta con las relaciones
     */
    protected function queryWithRelations(): Builder{
        return $this->model::query()->with($this->getDetailsRelations());
    }
    // funciones para sobreescribir en caso de que se necesite cargar relaciones adicionales
    protected function getDetailsRelations(): array{
        return $this->relations;
    }

    protected function getSearchColumns(): array{
        return $this->searchColumns;
    }

    /**
     * Retorna las relaciones que se pueden ordenar
     */
    protected function getSortableRelations(): array{
        return $this->sortableRelations;
    }


    /**
     * Funcion que aplica la busqueda de strings en la tabla, verifica si en las columnas que debe buscar, hay un array (relaciones), si es asi, aplica la busqueda en la relacion, sino aplica la busqueda en la columna
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
     */
    private function applyColumnSearch(Builder $query, string $column, string $search, bool $isFirst): Builder{
        return $isFirst ? 
        $query->where($column, 'like', "%$search%") : 
        $query->orWhere($column, 'like', "%$search%");
    }
    /**
     * Funcion que aplica la consulta de busqueda en las relaciones de la tabla
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
     * Funcion que aplica el filtrado, orquesta todo el filtrado de la tabla, verifica si hay busqueda, si hay busqueda aplica la busqueda, si hay ordenamiento aplica el ordenamiento
     */
    protected function applyPaginate ( TableQueryDTO $dto, ?Builder $query = null): LengthAwarePaginator{
        $query === null && $query = $this->queryWithRelations();
        if(!empty($dto->search)){
            $query = $this->applySearch($query, $this->getSearchColumns(), $dto->search);
        }
        if(!empty($dto->sortBy) && !empty($dto->sortOrder)){
           $query = $this->applySort($dto, $query);
        }
        return $query->paginate($dto->perPage);
        
    }

    /**
     * Funcion que ordena las consultas, verifica si la relacion esta declarada en las propiedades del objeto, y si es asi, aplica el ordenamiento de las relaciones, si no, aplica un ordenamiento normal
     */
    protected function applySort(TableQueryDTO $dto, Builder $query){
        if(array_key_exists($dto->sortBy, $this->getSortableRelations())){
            return $this->executeOrderQueryWithRelations($dto, $query);
        }
        return $query->orderBy($dto->sortBy, $dto->sortOrder);
    }
     protected function applyWheres(Builder $query, array $wheres): Builder{
        /** @var WhereFilterQueryDTO[] $wheres */
        foreach($wheres as $where){
            $query->where($where->column, $where->operator->value, $where->value, $where->logic);
        }
        return $query;
    }
    /**
     * Funcion que ordena las consultas con relaciones, es decir, las filtra por las columnas de las relaciones
     */
    private function executeOrderQueryWithRelations (TableQueryDTO $dto, Builder $query): Builder{
        /**
         * obtiene las relaciones declaradas como sorteables (ordenables) de la tabla
         */
        $relationData = $this->getSortableRelations()[$dto->sortBy];
        /**
         * Obtiene el nombre de la relacion
         */
            $relation = $relationData['relation'];
            /**
             * Obtiene la columna de la relacion
             */
            $column = $relationData['column'];
            $relationInstance = $this->model::query()->getModel()->{$relation}();
            // Obtiene la tabla de la relacion
            $relatedTable = $relationInstance->getRelated()->getTable();
            // obtiene la llave foranea de la relacion, de la tabla principal
            $foreignKey = $relationInstance->getQualifiedForeignKeyName();
            // Obtiene la clave propia de la relacion, es decir la llave de la tabla relacionada
            $ownerKey = $relationInstance->getQualifiedOwnerKeyName();
            return $query->leftJoin($relatedTable, $foreignKey, '=', $ownerKey)
                    ->orderBy($column, $dto->sortOrder) // ordena por la columna de la relacion y en el orden indicado
                    ->select($this->model::query()->getModel()->getTable().'.*'); // selecciona todas las columnas de la tabla principal
    }
}